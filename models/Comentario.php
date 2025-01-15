<?php

namespace Model;

class Comentario extends ActiveRecord {
    protected static $tabla = 'comentarios';
    protected static $columnasDB = [
        'id',
        'texto',
        'usuario_id',
        'publicacion_id',
        'parent_comment_id',
        'fecha_creacion'
    ];

    public $id;
    public $texto;
    public $usuario_id;
    public $publicacion_id;
    public $parent_comment_id;
    public $fecha_creacion;

    public function __construct($args = []) {
        $this->id                = $args['id'] ?? null;
        $this->texto             = $args['texto'] ?? '';
        $this->usuario_id        = $args['usuario_id'] ?? null;
        $this->publicacion_id    = $args['publicacion_id'] ?? null;
        $this->parent_comment_id = $args['parent_comment_id'] ?? null;
        $this->fecha_creacion    = $args['fecha_creacion'] ?? null;
    }

    public function validar() {
        if(!$this->texto) {
            self::$alertas['error'][] = 'El texto del comentario no puede estar vacío';
        }
        return self::$alertas;
    }

    // Sobrescribir el método atributos
    public function atributos() {
        $atributos = parent::atributos(); // Obtener los atributos del ActiveRecord

        // Si parent_comment_id es null, lo eliminamos del array de atributos
        if (is_null($this->parent_comment_id)) {
            unset($atributos['parent_comment_id']);
        }

        return $atributos;
    }

    // Método estático para contar cuántos comentarios hay para una publicación
    public static function countByPublicacion($publicacionId) {
        $publicacionId = self::$db->escape_string($publicacionId);

        $query = "SELECT COUNT(*) AS total FROM " . static::$tabla . "
                  WHERE publicacion_id = '{$publicacionId}'";
        $resultado = self::$db->query($query);

        $row = $resultado->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public static function findByPublicacionAsTree($publicacionId) {
        // 1. Obtener todos los comentarios lineales
        $id = self::$db->escape_string($publicacionId);
        $query = "SELECT * FROM " . static::$tabla . "
                  WHERE publicacion_id = '{$id}'
                  ORDER BY fecha_creacion ASC";
        $allComments = self::consultarSQL($query);
    
        // 2. Indexarlos por su id
        $indexed = [];
        foreach($allComments as $coment) {
            $indexed[$coment->id] = $coment;
        }
    
        // 3. Construir children[]
        //    Para cada comentario, si tiene parent_comment_id, lo metemos en ->children del padre
        foreach($indexed as $coment) {
            $coment->children = []; 
        }
        // Rellenamos
        $tree = [];
        foreach($indexed as $coment) {
            if($coment->parent_comment_id) {
                // Es un hijo
                $padreId = $coment->parent_comment_id;
                if(isset($indexed[$padreId])) {
                    $indexed[$padreId]->children[] = $coment;
                }
            } else {
                // Es un top-level (no parent)
                $tree[] = $coment;
            }
        }
    
        return $tree; 
        // $tree contendrá solo los top-level, cada uno con ->children con subcomentarios recursivamente
    }

    public function guardar() {
        // Si parent_comment_id es null, lo eliminamos del objeto antes de guardar
        if (is_null($this->parent_comment_id)) {
            unset($this->parent_comment_id);
        }
    
        return parent::guardar();
    }
    

    // Puedes sobrescribir otros métodos si es necesario
}

<?php

namespace Model;

class Publicacion extends ActiveRecord {
    protected static $tabla = 'publicaciones';
    protected static $columnasDB = [
        'id',
        'titulo',
        'texto',
        'media',
        'usuario_id',
        'fecha_creacion'
    ];

    public $id;
    public $titulo;
    public $texto;
    public $media;
    public $usuario_id;
    public $fecha_creacion;

    public function __construct($args = []) {
        $this->id             = $args['id'] ?? null;
        $this->titulo         = $args['titulo'] ?? '';
        $this->texto          = $args['texto'] ?? '';
        $this->media          = $args['media'] ?? null;
        $this->usuario_id     = $args['usuario_id'] ?? null;
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
    }

    // Validar
    public function validar() {
        if(!$this->titulo) {
            self::$alertas['error'][] = 'El título es obligatorio';
        }
        if(!$this->texto) {
            self::$alertas['error'][] = 'El texto de la publicación no puede estar vacío';
        }
        return self::$alertas;
    }

    // Método para contar comentarios
    public function contarComentarios() : int {
        return Comentario::countByPublicacion($this->id);
    }
}

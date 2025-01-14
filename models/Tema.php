<?php

namespace Model;

class Tema extends ActiveRecord {
    protected static $tabla = 'tema';
    protected static $columnasDB = ['id', 'titulo', 'descripcion', 'unidad_id', 'doc_ruta'];

    public $id;
    public $titulo;
    public $descripcion;
    public $unidad_id;
    public $doc_ruta;

    public function __construct($args = []) {
        $this->id          = $args['id'] ?? null;
        $this->titulo      = $args['titulo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->unidad_id   = $args['unidad_id'] ?? null;
        $this->doc_ruta    = $args['doc_ruta'] ?? null;
    }

    // Ejemplo de validación
    public function validar() {
        if(!$this->titulo) {
            self::$alertas['error'][] = 'El título del Tema es obligatorio';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripción del Tema es obligatoria';
        }
        if(!$this->unidad_id) {
            self::$alertas['error'][] = 'El ID de la Unidad es obligatorio';
        }
        return self::$alertas;
    }
}
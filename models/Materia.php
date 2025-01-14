<?php

namespace Model;

class Materia extends ActiveRecord {
    protected static $tabla = 'materia';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = []) {
        $this->id     = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    // Podrías agregar validaciones si lo deseas
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre de la Materia es obligatorio';
        }
        return self::$alertas;
    }
}

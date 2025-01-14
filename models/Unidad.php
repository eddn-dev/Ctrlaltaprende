<?php

namespace Model;

class Unidad extends ActiveRecord {
    protected static $tabla = 'unidad';
    protected static $columnasDB = ['id', 'nombre', 'materia_id'];

    public $id;
    public $nombre;
    public $materia_id;

    public function __construct($args = []) {
        $this->id         = $args['id'] ?? null;
        $this->nombre     = $args['nombre'] ?? '';
        $this->materia_id = $args['materia_id'] ?? null;
    }

    // Ejemplo de validación
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre de la Unidad es obligatorio';
        }
        if(!$this->materia_id) {
            self::$alertas['error'][] = 'El ID de la Materia es obligatorio';
        }
        return self::$alertas;
    }
}

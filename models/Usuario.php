<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Asegúrate de que estas columnas coincidan con tu tabla 'usuarios'
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id',
        'nombre',
        'boleta',
        'email',
        'password',
        'confirmado',
        'token',
        'admin',
        'descripcion',
        'profile',
        'skills'
    ];

    public $id;
    public $nombre;
    public $boleta;
    public $email;
    public $password;
    public $password2;
    public $confirmado;
    public $token;
    public $admin;
    public $descripcion;
    public $profile;
    public $skills;

    public $password_actual;
    public $password_nuevo;

    public function __construct($args = [])
    {
        $this->id          = $args['id'] ?? null;
        $this->nombre      = $args['nombre'] ?? '';
        $this->boleta      = $args['boleta'] ?? '';
        $this->email       = $args['email'] ?? '';
        $this->password    = $args['password'] ?? '';
        $this->password2   = $args['password2'] ?? '';
        $this->confirmado  = $args['confirmado'] ?? 0;
        $this->token       = $args['token'] ?? '';
        $this->admin       = $args['admin'] ?? 0;
        $this->descripcion = $args['descripcion'] ?? null;
        $this->profile     = $args['profile'] ?? null;
        $this->skills      = $args['skills'] ?? null;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacío';
        }
        return self::$alertas;
    }

    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->boleta) {
            self::$alertas['error'][] = 'La Boleta es Obligatoria';
        }
        if(strlen($this->boleta) !== 10) {
            self::$alertas['error'][] = 'La Boleta debe tener 10 caracteres';
        }        
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        } else {
            // Primero validamos que tenga formato de email básico
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$alertas['error'][] = 'Formato de Email no válido';
            } else {
                // Luego validamos que termine en '@alumno.ipn.mx'
                if (!preg_match('/@alumno\.ipn\.mx$/i', $this->email)) {
                    self::$alertas['error'][] = 'El correo debe ser de dominio @alumno.ipn.mx';
                }
            }
        }        
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacío';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los Passwords son diferentes';
        }
        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacío';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacío';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacío';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() : void {
        $this->token = uniqid();
    }
}

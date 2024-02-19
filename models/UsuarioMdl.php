<?php

class Usuario {
    private $idusuario;
    private $nombre;
    private $apellido;
    private $tipo;
    private $mail;
    private $contrasena;

    public function __construct($nombre, $apellido, $tipo, $mail, $contrasena ="") {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->tipo = $tipo;
        $this->mail = $mail;
        $this->contrasena = $contrasena;
    }

    // Getters y setters

    public function getIdUsuario() {
        return $this->idusuario;
    }

    public function setIdUsuario($id) {
        $this->idusuario = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }
}

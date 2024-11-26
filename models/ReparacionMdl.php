<?php

class ReparacionMdl
{
    private $modelo;
    private $marca;
    private $numeroSerie;
    private $descripcion;

    public function __construct($modelo, $marca, $numeroSerie, $descripcion)
    {
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->numeroSerie = $numeroSerie;
        $this->descripcion = $descripcion;
    }

    // Getters y setters

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
}
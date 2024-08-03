<?php

class ReparacionMdl
{
    private $modelo;
    private $marca;
    private $tipo;
    private $numeroSerie;
    private $descripcion;
    private $total;

    public function __construct($modelo, $marca, $tipo, $numeroSerie, $descripcion, $total)
    {
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->tipo = $tipo;
        $this->numeroSerie = $numeroSerie;
        $this->descripcion = $descripcion;
        $this->total = $total;
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

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->modelo = $tipo;
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

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }
}
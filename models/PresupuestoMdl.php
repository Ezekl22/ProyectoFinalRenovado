<?php

class PresupuestoMdl {
    private $idpresupuesto;
    private $idcliente;
    private $nrocomprobante;
    private $tipo;
    private $estado;
    private $fecha;
    private $puntoventa;
    private $total;

    public function __construct($idcliente, $nrocomprobante, $tipo, $estado, $fecha, $puntoventa, $total) {
        $this->idcliente = $idcliente;
        $this->nrocomprobante = $nrocomprobante;
        $this->tipo = $tipo;
        $this->estado = $estado;
        $this->fecha = $fecha;
        $this->puntoventa = $puntoventa;
        $this->total = $total;
    }

    // Getters y setters

    public function getIdPresupuesto() {
        return $this->idpresupuesto;
    }

    public function setIdPresupuesto($idpresupuesto) {
        $this->idpresupuesto = $idpresupuesto;
    }

    public function getIdCliente() {
        return $this->idcliente;
    }

    public function setIdCliente($idcliente) {
        $this->idcliente = $idcliente;
    }

    public function getNroComprobante() {
        return $this->nrocomprobante;
    }

    public function setNroComprobante($nrocomprobante) {
        $this->nrocomprobante = $nrocomprobante;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getPuntoVenta() {
        return $this->puntoventa;
    }

    public function setPuntoVenta($puntoventa) {
        $this->puntoventa = $puntoventa;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}
<?php

class PresupuestoMdl
{
    private $idpresupuesto;
    private $idcliente;
    private $nrocomprobante;
    private $tipo;
    private $estado;
    private $fecha;
    private $puntoventa;
    /** agrego esto para especificar de que tipo es para que lo tome el entorno de desarrollo
     * @var ProductoPresupuestoMdl[]
     */
    private array $productos;
    private $total;

    public function __construct($idcliente, array $productos, $nrocomprobante, $tipo, $estado, $puntoventa, $total)
    {
        $this->idcliente = $idcliente;
        $this->productos = $productos;
        $this->nrocomprobante = $nrocomprobante;
        $this->tipo = $tipo;
        $this->estado = $estado;
        $this->puntoventa = $puntoventa;
        $this->total = $total;
    }

    // Getters y setters

    public function getIdPresupuesto()
    {
        return $this->idpresupuesto;
    }

    public function setIdPresupuesto($idpresupuesto)
    {
        $this->idpresupuesto = $idpresupuesto;
    }

    public function getIdCliente()
    {
        return $this->idcliente;
    }

    public function setIdCliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }

    public function getProductos()
    {
        return $this->productos;
    }

    public function setProductos($productos)
    {
        $this->productos = $productos;
    }

    public function getNroComprobante()
    {
        return $this->nrocomprobante;
    }

    public function setNroComprobante($nrocomprobante)
    {
        $this->nrocomprobante = $nrocomprobante;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getPuntoVenta()
    {
        return $this->puntoventa;
    }

    public function setPuntoVenta($puntoventa)
    {
        $this->puntoventa = $puntoventa;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
}
<?php
require_once 'models/PresupuestoMdl.php';
require_once 'models/ReparacionMdl.php';
require_once 'models/PresupuestoDAO.php';
require_once 'models/ProductoPresupuestoMdl.php';
require_once 'controladores/ClienteCtr.php';
require_once 'controladores/ProductoCtr.php';
require_once 'controladores/ToastCtr.php';
require_once 'controladores/ErrorCtr.php';

class PresupuestoCtr
{
    private $presupuestoDAO;
    private $clienteCtr;
    private $productoCtr;

    private static $instance = null;

    public function __construct()
    {
        $this->presupuestoDAO = new PresupuestoDAO();
        $this->clienteCtr = ClienteCtr::getInstance();
        $this->productoCtr = new ProductoCtr();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : "";
        $toast = new ToastCtr();
        if ($status == "error") {
            $description = isset($_GET['description']) ? $_GET['description'] : "";
            ErrorCtr::getInstance()->showError($description, "");
        }
        switch ($action) {
            case 'create':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($status != "success") {
                        $this->create();
                    }
                }
                break;
            case 'created':
                $toast->mostrarToast("exito", "Presupuesto creado");
                break;
            case 'annulled':
                if ($status != "success") {
                    $this->annulled($id);
                } else {
                    $toast->mostrarToast("exito", "Presupuesto anulado");
                }
                break;
            case 'edit':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($status != "success") {
                        $this->update($id);
                    }
                }
                break;
            case 'updated':
                $toast->mostrarToast("exito", "Presupuesto modificado");
                break;
            case 'facturar':
                if ($status != "success") {
                    $this->facturar($id);
                } else {
                    $toast->mostrarToast("exito", "Presupuesto facturado");
                }
                break;
            case 'cambiarestado':
                if ($status != "success") {
                    $this->cambiarEstado($id);
                } else {
                    $toast->mostrarToast("exito", "Se cambio el estado del presupuesto");
                }
            case 'searched':
                $this->search();
                break;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PresupuestoCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $action = $gestionPantallaCtr->getAction();

        $presupuestos = $action == "searched" ? $this->search() : $this->presupuestoDAO->getAllPresupuestos();
        if (is_string($presupuestos)) {
            ErrorCtr::getInstance()->showError($presupuestos, "error al traer todos los presupuestos");
        }

        $presupuestoCtr = $this->getInstance();
        $productosPre = [];
        if ($action == 'see') {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $presupuesto = $this->getPresupuestoById($id);
            $cliente = $this->getClienteById($presupuesto->getIdCliente());
            $nombreCliente = $cliente['nombre'] . ' ' . $cliente['apellido'];
            $productosPre = $this->getProductosPresupuestoById($presupuesto->getIdPresupuesto());
            $total = 0;
        }

        for ($i = 0; $i < count($presupuestos); $i++) {
            $presupuestos[$i][1] = $this->getNombreClienteById($presupuestos[$i][1]);
        }

        session_start();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRESUPUESTOS, $presupuestos, [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        // Cargar la vista con los datos
        require_once 'vistas/presupuesto/presupuesto.php';
    }

    public function getReparacionPresupuestoById($id)
    {
        $reparacion = $this->presupuestoDAO->getReparacionPresupuestoById($id);

        if (is_string($reparacion)) {
            ErrorCtr::getInstance()->showError($reparacion, "error al traer la reparacion");
        }
        return $reparacion;

    }

    public function getPantallaCreate()
    {
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $this->index();
        require_once 'vistas/presupuesto/create.php';
    }

    public function create()
    {
        if (isset($_POST['tipo'])) {
            if ($_POST['tipo'] == "Venta") {
                $productos_total = $this->getProductos_Total();
                $estado = isset($_POST['tipo']) ? $_POST['tipo'] == 'Venta' ? 'Presupuestado' : 'Pendiente presupuesto' : '';
                $presupuesto = new PresupuestoMdl(
                    $_POST['idcliente'],
                    $productos_total->productos,
                    $this->getNuevoNroComprobante(),
                    $_POST['tipo'],
                    $estado,
                    '0001',
                    $productos_total->total
                );
                $status = $this->presupuestoDAO->create($presupuesto);
            } else if ($_POST['tipo'] == "Reparacion") {
                $presupuesto = new PresupuestoMdl($_POST['idcliente'], [], $this->getNuevoNroComprobante(), $_POST['tipo'], 'pendiente presupuesto', '0001', 0);
                $reparacion = new ReparacionMdl($_POST['modelo'], $_POST['marca'], $_POST['nroserie'], $_POST['descripcion']);
                $status = $this->presupuestoDAO->create($presupuesto, $reparacion);
            }

            if ($status == "") {
                header("Location: index.php?module=presupuestos&action=created&status=success");
            } else {
                header("Location: index.php?module=presupuestos&status=error&description=" . $status);
            }
        }
    }

    private function getProductos_Total()
    {
        $productos = [];
        $precioTotal = 0;
        foreach ($_POST['idproductos'] as $index => $idproducto) {
            $precioUnit = $this->productoCtr->getProductoById($idproducto)['precioventa'];
            $cantidad = intval($_POST['cantidad'][$index]);
            $producto = new ProductoPresupuestoMdl($idproducto, $precioUnit, $cantidad);
            $precioTotal += $precioUnit * $cantidad;
            array_push($productos, $producto);
        }
        $productos_Total = new stdClass();
        $productos_Total->productos = $productos;
        $productos_Total->total = $precioTotal;

        return $productos_Total;
    }

    public function getPantallaEdit()
    {
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $this->index();
        require_once 'vistas/presupuesto/edit.php';
    }

    public function getNuevoNroComprobante()
    {
        $auxNroComprobante = strval($this->presupuestoDAO->getNuevoNroComprobante() + 1);
        if (is_string($auxNroComprobante)) {
            ErrorCtr::getInstance()->showError($auxNroComprobante, "error al traer el numero del comprobante");
        }
        $nroComprobante = str_pad($auxNroComprobante, 10, 0, STR_PAD_LEFT);
        return $nroComprobante;
    }

    public function getNombreClienteById($id)
    {
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente['nombre'] . ' ' . $cliente['apellido'];
    }

    public function getClienteById($id)
    {
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente;
    }

    public function getProductoById($id)
    {
        $producto = $this->productoCtr->getProductoById($id);
        return $producto;
    }

    public function getProductosPresupuestoById($id)
    {
        $productoPresupuesto = $this->presupuestoDAO->getProductosPresupuestoById($id);
        if (is_string($productoPresupuesto)) {
            ErrorCtr::getInstance()->showError($productoPresupuesto, "error al traer los productos del presupuesto");
        }
        return $productoPresupuesto;
    }

    public function update($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["idcliente"])) {
                $presupuesto = $this->getPresupuestoById($id);
                $presupuesto->setIdCliente($_POST['idcliente']);
                if ($presupuesto->getTipo() == "Venta") {
                    $productos_total = $this->getProductos_Total();
                    $presupuesto->setProductos($productos_total->productos);
                    $presupuesto->setTotal($productos_total->total);
                }
                $status = $this->presupuestoDAO->updatePresupuesto($presupuesto);
            }
        }
        if ($status == "") {
            header("Location: index.php?module=presupuestos&action=updated&status=success");
        } else {
            header("Location: index.php?module=presupuestos&status=error&description=" . $status);
        }
    }

    public function getPresupuestoById($id)
    {
        $presupuestoBD = $this->presupuestoDAO->getPresupuestoById($id);
        if (is_string($presupuestoBD)) {
            ErrorCtr::getInstance()->showError($presupuestoBD, "error al traer el presupuesto");
        }
        $productosPresupuestoBD = $this->getProductosPresupuestoById($id);

        if (is_string($productosPresupuestoBD)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al buscar presupuesto: " . $presupuestoBD);
            return "";
        }
        $presupuesto = new PresupuestoMdl($presupuestoBD['idcliente'], $productosPresupuestoBD, $presupuestoBD['nrocomprobante'], $presupuestoBD['tipo'], $presupuestoBD['estado'], $presupuestoBD['puntoventa'], $presupuestoBD['total']);
        $presupuesto->setIdPresupuesto($id);
        $presupuesto->setFecha($presupuestoBD['fecha']);
        return $presupuesto;
    }

    public function getPantallaAnnul()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('annul', 'Anular Presupuesto', "", BOTONES_POPUP_ANULAR, 'index.php?action=annul'));
        $this->index();
    }

    public function annulled($id)
    {
        $presupuesto = $this->getPresupuestoById($id);
        $estado = $presupuesto->getEstado();

        if ($estado != 'Pendiente presupuesto' || $estado != 'En reparacion' || $estado != '')
            $status = $this->presupuestoDAO->annul($id);
        if ($status == "") {
            header("Location: index.php?module=presupuestos&action=annulled&status=success");
        } else {
            header("Location: index.php?module=presupuestos&action=annulled&status=error&description=" . $status);
        }
    }

    public function getAllClientes()
    {
        return $this->clienteCtr->getAllClientes();
    }

    public function getAllProductos()
    {
        return $this->productoCtr->getAllProductos();
    }

    public function facturar($id)
    {
        $presupuesto = $this->getPresupuestoById($id);
        $estado = $presupuesto->getEstado();
        if ($estado != 'Pendiente presupuesto' && $estado != 'En reparacion' && $estado != '' && $estado != 'Facturado') {
            $presupuesto->setEstado('Facturado');
            $presupuesto->setNroComprobante('C-' . $presupuesto->getNroComprobante() . '-0001');
            $status = $this->updatePresupuesto($presupuesto);
            if ($status == "") {
                header("Location: index.php?module=presupuestos&action=facturar&status=success");
            } else {
                header("Location: index.php?module=presupuestos&status=error&description=" . $status);
            }
        }
    }

    private function updatePresupuesto($presupuesto)
    {
        return $this->presupuestoDAO->updatePresupuesto($presupuesto);
    }

    public function cambiarEstado($id)
    {
        $presupuesto = $this->getPresupuestoById($id);
        $tipo = $presupuesto->getTipo();
        $estado = $presupuesto->getEstado();
        $status = "";
        if ($tipo == "Venta") {
            if ($estado == "Presupuestado") {
                $presupuesto->setEstado('Facturado');
                $presupuesto->setNroComprobante('C-' . $presupuesto->getNroComprobante() . '-0001');
                $status = $this->updatePresupuesto($presupuesto);
            }
        } else {
            if ($estado == "Presupuestado") {
                $presupuesto->setEstado('En reparacion');
                $status = $this->updatePresupuesto($presupuesto);
            }
            if ($estado == "Reparado") {
                $presupuesto->setEstado('Facturado');
                $presupuesto->setNroComprobante('C-' . $presupuesto->getNroComprobante() . '-0001');
                $status = $this->updatePresupuesto($presupuesto);
            }
        }
        if ($status == "") {
            header("Location: index.php?module=presupuestos&action=cambiarestado&status=success");
        } else {
            header("Location: index.php?module=presupuestos&status=error&description=" . $status);
        }

    }

    public function search()
    {
        $result = $this->presupuestoDAO->search();
        if (is_string($result)) {
            ErrorCtr::getInstance()->showError($result, "error al buscar presupuestos");
        }
        return $result;
    }

    public function getPresupuestoDAO()
    {
        return $this->presupuestoDAO;
    }
}

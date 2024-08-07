<?php
require_once 'models/PresupuestoMdl.php';
require_once 'models/PresupuestoDAO.php';
require_once 'models/ProductoPresupuestoMdl.php';
require_once 'controladores/ClienteCtr.php';
require_once 'controladores/ProductoCtr.php';

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

        switch ($action) {
            case 'create':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $status = isset($_GET['status']) ? $_GET['status'] : "";
                    if ($status != "success") {
                        $this->create();
                    }
                }
                break;
            case 'annulled':
                $this->annulled($id);
                break;
            case 'edited':
                $this->update($id);
                break;
            case 'facturar':
                $this->facturar($id);
                break;
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

        $presupuestoCtr = $this;
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
        if (isset($_POST['idcliente'])) {
            $productos = [];
            $precioTotal = 0;
            $estado = isset($_POST['tipo']) ? $_POST['tipo'] == 'Venta' ? 'Presupuestado' : 'Pendiente presupuesto' : '';
            foreach ($_POST['idproductos'] as $index => $idproducto) {
                $precioUnit = $this->productoCtr->getProductoById($idproducto)['precioventa'];
                $cantidad = intval($_POST['cantidad'][$index]);
                $producto = new ProductoPresupuestoMdl($idproducto, $precioUnit, $cantidad);
                $precioTotal += $precioUnit * $cantidad;
                array_push($productos, $producto);
            }
            $presupuesto = new PresupuestoMdl(
                $_POST['idcliente'],
                $productos,
                $this->getNuevoNroComprobante(),
                $_POST['tipo'],
                $estado,
                '0001',
                $precioTotal
            );
            $status = $this->presupuestoDAO->create($presupuesto);
            if ($status != "") {
                header("Location: index.php?module=presupuestos&status=success");
            } else {
                header("Location: index.php?module=presupuestos&status=error&description=" . $status);
            }
        }
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/presupuesto/edit.php';
    }

    public function getNuevoNroComprobante()
    {
        $auxNroComprobante = strval($this->presupuestoDAO->getNuevoNroComprobante() + 1);
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
        return $this->presupuestoDAO->getProductosPresupuestoById($id);
    }

    public function update($id)
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["idcliente"])) {
                $presupuesto = new PresupuestoMdl($_POST["idcliente"], $_POST["nrocomprobante"], $_POST['tipo'], $_POST["estado"], $_POST["fecha"], $_POST["puntoventa"], $_POST["total"]);
                $presupuesto->setIdPresupuesto($id);
                $this->presupuestoDAO->updatePresupuesto($presupuesto);
            }
        }
    }

    public function getPresupuestoById($id)
    {
        $presupuestoBD = $this->presupuestoDAO->getPresupuestoById($id);
        $productosPresupuestoBD = $this->presupuestoDAO->getProductosPresupuestoById($id);
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
            $this->presupuestoDAO->annul($id);
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
            $this->presupuestoDAO->updatePresupuesto($presupuesto);
        }
    }

    public function search()
    {
        return $this->presupuestoDAO->search();
    }
}

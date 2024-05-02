<?php

class MenuCtr
{

    public function __construct()
    {

    }

    public function index()
    {
        // Cargor la vista con los datos
        $datos = $this->filtrarMenu();
        require_once 'vistas/menu/index.php';
    }

    private function filtrarMenu()
    {
        // Verificar si $_SESSION['tipoUsuario'] está definido y no está vacío

        if (isset($_SESSION['session']) && $_SESSION['session'] !== "") {
            $tipoUsuario = $_SESSION['session']->getUsuarioSesionado()->getTipo();
            return strcasecmp($tipoUsuario, "ADMINISTRADOR") == 0 || strcasecmp($tipoUsuario, "ADMINISTRADOR BASE") == 0 ?
                DATOS_CARDS : array_filter(DATOS_CARDS, function ($datosCard) {
                    $nombreCard = key($datosCard);
                    $tipoUsuario = $_SESSION['session']->getUsuarioSesionado()->getTipo();
                    $accesoVendedor = ['Presupuestos', 'Clientes', 'Pedidos de compra', 'Productos'];
                    $accesoReparador = ['Productos', 'Reparaciones'];

                    return strcasecmp($tipoUsuario, "VENDEDOR") == 0
                        ? in_array($nombreCard, $accesoVendedor, true)
                        : in_array($nombreCard, $accesoReparador, true);
                });
        } else {
            // Manejar la falta de $_SESSION['tipoUsuario']
            echo "Error: La variable de sesión tipoUsuario no está definida o está vacía.";
        }
    }

}
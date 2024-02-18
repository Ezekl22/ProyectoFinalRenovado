<?php
define(
    'DATOS_CARDS',
    array(
        [
            "Presupuestos" => "En esta pantalla se pueden ver los presupuestos de reparaciones o ventas.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
        ],
        [
            "Pedidos de compra" => "En esta pantalla se pueden ver los pedidos de compra.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
        ],
        [
            "Reparaciones" => "En esta pantalla se pueden ver las reparaciones.
        Solo pueden acceder los usuarios de tipo reparador o administrador."
        ],
        [
            "Productos" => "En esta pantalla se pueden ver los productos.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
        ],
        [
            "Usuarios" => "En esta pantalla se pueden ver los usuarios.
        Solo pueden acceder los usuarios de tipo administrador."
        ],
        [
            "Clientes" => "En esta pantalla se pueden ver los clientes.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
        ],
        [
            "Proveedores" => "En esta pantalla se pueden ver los proveedores.
        Solo pueden acceder los usuarios de tipo vendedor o administrador."
        ]
    )
);

define('GRILLA_USUARIOS', array("Nombre", "Apellido", "Tipo", "Mail"));
define('GRILLA_PRESUPUESTO_PRODUCTOS', array("Producto", "Cantidad", "Valor unitario", "Total", "Selección"));
define('BOTONES_POPUP_PRODUCTOS', array(["texto" => "Cancelar", "tipo" => "button", "href" => ""], ["texto" => "Seleccionar", "tipo" => "button", "href" => "", "onclick" => "cargarGrillaProducto()"]));

define('INICIO_SESION_BTN_P', array(["texto" => "Cancelar", "tipo" => "button", "href" => ""], ["texto" => "Ingresar", "tipo" => "submit", "href" => ""]));
$recuperarContrasenaBotonesP = array(["texto" => "cancelar", "tipo" => "button", "href" => ""], ["texto" => "Enviar", "tipo" => "submit", "href" => ""]);
$ingresarCodigoBotonesP = array(["texto" => "cancelar", "tipo" => "button", "href" => ""], ["texto" => "Verificar", "tipo" => "submit", "href" => ""]);
$cambiarContrasenaBotonesP = array(["texto" => "cancelar", "tipo" => "button", "href" => ""], ["texto" => "Guardar", "tipo" => "submit", "href" => ""]);

// este codigo es la parte superior del body
define('POPUP_PRODUCTOS_CUERPO_S', `<div class="d-flex mt-3 justify-content-end" style="width:90%;">
                                <div class="input-group input-group-sm w-25">
                                    <input type="text" class="form-control" placeholder="Ingrese su busqueda" aria-label="Recipient's username" aria-describedby="buscar">
                                    <input class="btn btn-outline-secondary button" type="button" id="buscar" value="Buscar"></button>
                                </div>
                                </div>
                                <div class="border mt-3 mb-5 rounded-4" style="width:90%;">
                                <table class="grilla__contenedor border-0">
                                    <tr class="grilla grilla__cabecera">
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Detalle</th>
                                        <th>Stock</th>
                                        <th>Tipo</th>
                                        <th>preciocompra</th>
                                        <th>precioventa</th>
                                        <th>selección</th>
                                    </tr>`);

//                                    
define('POPUP_PRODUCTOS_CUERPO_I', `</table>
<div class="d-flex justify-content-center">
    <div class="input-group input-group-sm mb-3 w-25">
        <label class="input-group-text" for="cantidad" id="inputGroup-sizing-sm">Cantidad:</label>
        <input type="text" class="form-control" aria-label="0" id="cantidadProducto" value="1">
    </div>
</div>
</div>`)
    ?>
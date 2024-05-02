<!DOCTYPE html>
<?php
$PresupuestoCtr = new PresupuestoCtr();
$clientes = $PresupuestoCtr->getAllClientes();
$json = json_encode($PresupuestoCtr->getAllProductos());
echo "<script>const productos = $json;</script>";
?>
<html>

<head>
    <title>Crear Presupuesto</title>
</head>

<body>
    <main class="d-flex flex-column align-items-center mt-2 mb-4 main__flex" id="editPresupuesto">
        <article class="mt-4">
            <h2 class="main__title mb-5">
                Crear Presupuesto
            </h2>
        </article>
        <article class="editar__contenedor rounded-4">
            <form action="index.php?module=presupuestos&action=created" method="POST"
                class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                <div class="d-flex flex-column align-items-center contenedor__mayor" id="contenedor">
                    <div class="my-5 d-flex flex-row w-100">
                        <div class="input-group input-group-sm mx-7">
                            <label class="input-group-text" for="cliente">Cliente:</label>
                            <select class="form-select" id="idcliente" name="idcliente" required>
                                <?php foreach ($clientes as $cliente) { ?>
                                    <option value="<?php echo $cliente['idcliente'] ?>">
                                        <?php echo $cliente['nombre'] . ' ' . $cliente['apellido'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mx-7">
                            <label class="input-group-text input-group-sm" for="tipo">Tipo:</label>
                            <select class="form-select" id="tipo" name="tipo" onchange="tipoOnChange(event)" required>
                                <option value="Venta">Venta</option>
                                <option value="Reparacion">Reparacion</option>
                            </select>
                        </div>
                    </div>
                    <h4 class="mt-2 text__white">Productos</h4>
                    <div class="d-flex justify-content-start w-100">
                        <button class="btn btn-outline-secondary button align-self-start ms-5"
                            data-bs-target="#grillaProductos" data-bs-toggle="modal" type="button" id="agregar"
                            onclick="mostrarGrillaProductos()">Agregar producto</button>
                        <button class="btn btn-outline-secondary button ms-3 align-self-start" disabled
                            onclick="quitarComponenteProducto('${id}')" type="button" id="quitar">Quitar
                            productos</button>
                    </div>

                    <div class="my-3 d-flex flex-column w-100" id="contProductos">
                        <?php include "vistas/otros/grillaProductosSeleccionados.php" ?>
                    </div>
                    <div class="d-flex" id="">
                        <div class="input-group input-group-sm mb-3">
                            <label class="input-group-text" for="totalProductos"
                                id="inputGroup-sizing-sm">Total:</label>
                            <input type="text" class="form-control" disabled aria-label="0" id="totalproductos"
                                value="$0,00">
                        </div>
                    </div>
                    <input class="btn button my-2" type="submit" value="Guardar cambios">
                </div>
            </form>
            <?php $gestionPantallaCtr->crearPopUp(new PopUpMdl('grillaProductos', 'Productos', "", BOTONES_POPUP_PRODUCTOS, '')); ?>
        </article>
    </main>
</body>

</html>
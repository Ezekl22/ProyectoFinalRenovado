<!DOCTYPE html>
<?php
$PresupuestoCtr = PresupuestoCtr::getInstance();
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
            <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
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
                                <option value="Venta" <?php echo !isset($_GET["type"]) || $_GET["type"] != "Reparacion" ? "selected" : "" ?>>Venta</option>
                                <option value="Reparacion" <?php echo isset($_GET["type"]) && $_GET["type"] == "Reparacion" ? "selected" : "" ?>>Reparacion</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center contenedor__mayor" id="contGrillaFormulario">
                        <h4 class="mt-2 text__white">
                            <?php echo !isset($_GET["type"]) || $_GET["type"] != "Reparacion" ? "Productos" : "Equipo a reparar" ?>
                        </h4>
                        <?php if (isset($_GET['type']) && $_GET['type'] == "Reparacion") { ?>
                            <div class="my-3 d-flex flex-row w-95">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text" for="marca" id="inputGroup-sizing-sm">Marca:</label>
                                    <input type="text" class="form-control w-25" id="marca" name="marca" required>
                                </div>
                                <div class="input-group input-group-sm ms-3">
                                    <label class="input-group-text" for="nroserie" id="inputGroup-sizing-sm">Numero de
                                        serie:</label>
                                    <input type="text" class="form-control w-25" id="nroserie" name="nroserie" required>
                                </div>
                                <div class="input-group input-group-sm ms-3">
                                    <label class="input-group-text" for="modelo" id="inputGroup-sizing-sm">Modelo:</label>
                                    <input type="text" class="form-control w-25" id="modelo" name="modelo" required>
                                </div>
                            </div>
                            <div class="input-group w-75">
                                <label class="input-group-text" for="descripcion" id="input-group">Descripción:</label>
                                <textarea class="form-control" aria-label="" id="descripcion" name="descripcion"></textarea>
                            </div>
                        <?php } else { ?>
                            <div class="d-flex justify-content-start w-100">
                                <button class="btn btn-outline-secondary button align-self-start ms-5"
                                    data-bs-target="#grillaProductos" data-bs-toggle="modal" type="button" id="agregar"
                                    onclick="mostrarGrillaProductos()">Agregar producto</button>
                                <button class="btn btn-outline-secondary button ms-3 align-self-start" disabled
                                    onclick="quitarComponenteProducto()" type="button" id="btnQuitar">Quitar
                                    productos</button>
                            </div>

                            <div class="my-3 d-flex flex-column w-100" id="contProductos">
                                <?php include_once "vistas/otros/grillaProductosSeleccionados.php" ?>
                            </div>
                            <div class="d-flex" id="">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="totalProductos"
                                        id="inputGroup-sizing-sm">Total:</label>
                                    <input type="number" class="form-control" disabled aria-label="0" id="totalproductos"
                                        value="$0,00" step="any">
                                </div>
                            </div>

                        <?php } ?>
                        <div class="d-flex justify-content-evenly w-75">
                            <input class="my-5 btn button w-25" type="submit" value="Guardar">
                            <a class="my-5 btn button w-25" type="button"
                                href="index.php?module=presupuestos">Cancelar</a>
                        </div>
                    </div>


                </div>
            </form>
            <?php $gestionPantallaCtr->crearPopUp(new PopUpMdl('grillaProductos', 'Productos', "", BOTONES_POPUP_PRODUCTOS, '')); ?>
        </article>
    </main>
</body>

</html>
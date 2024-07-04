<!DOCTYPE html>
<html>

<head>
    <title>Presupuestos</title>
</head>

<body>
    <main class="main__flex">
        <article class="mt-4">
            <h2 class="main__title">
                Presupuestos
            </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">

            <div class="grilla contenedor__mayor-grilla d-flex flex-column align-items-center rounded-4">

                <div class="d-flex flex-row contenedor__mayor align-items-start mt-4">

                    <div class="d-flex w-100 alig-items-end">
                        <div class="form-check ms-3 text__white">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Facturado
                            </label>
                        </div>
                        <div class="form-check ms-4 text__white">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                No Facturado
                            </label>
                        </div>
                    </div>
                    <div class="d-flex w-75 justify-content-end">
                        <form action="index.php?module=presupuestos&action=searched" method="POST"
                            class="input-group input-group-sm w-75" id="formBuscador">
                            <input type="search" id="termino" name="termino" class="form-control"
                                placeholder="Ingrese su busqueda"
                                value="<?php echo isset($_POST['termino']) ? $_POST['termino'] : ""; ?>"
                                aria-label="Recipient's username" aria-describedby="buscar">
                            <input class="btn btn-outline-secondary button" type="submit" id="buscar"
                                value="Buscar"></button>
                        </form>
                    </div>
                </div>
                <?php if ($presupuestos && count($presupuestos) > 0) { ?>
                    <?php $grillaCtr->mostrarGrilla(); ?>
                <?php } else { ?>
                    <h3 class="grilla__mensaje-error">
                        <?php echo $action == 'searched' ? "No se han encontrado registros para esa busqueda" : "No hay presupuestos activos cree un presupuesto nuevo" ?>
                    </h3>
                <?php } ?>

            </div>
            <?php if ($action != 'create') { ?>
                <a class="my-5 btn button" type="button" href="index.php?module=presupuestos&action=create">Crear nuevo
                    presupuesto</a>
            <?php } ?>
        </article>
        <!-------------------------------------------------- Pop up ver presupuesto ---------------------------------------------->
        <div class="modal fade" id="ver" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog justify-content-center d-flex" style="max-width:none;">
                <div class="modal-content mx-3" style="width:80vw;">
                    <div class="modal-header headerPop__background">
                        <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo"
                            alt="logo de integral Service">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Productos</h2>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="w-100 d-flex flex-column align-items-center border border-2">
                            <div class="d-flex flex-row w-100 my-3 align-items-end">
                                <div class="d-flex align-items-start w-30 flex-column ms-5">
                                    <h4> Integral Service</h4>
                                    <div>Servico tecnico de equipos de impresion</div>
                                </div>
                                <div class="d-flex align-items-center w-30 flex-column ms-5">
                                    <div class="h2 border border-2 py-2 px-2 rounded-4">X</div>
                                    <div class="d-flex w-100 d-flex justify-content-center">
                                        <b class="h3">Presupuesto </b>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end w-30 flex-column me-5">
                                    <div>
                                        <div class="d-flex w-100 d-flex align-items-start">
                                            <b class="me-2">Dirección: </b> Balcarce 653 <b class="mx-2">Provincia: </b>
                                            Ente Ríos
                                        </div>
                                        <div class="d-flex w-100 align-items-start">
                                            <b class="me-2">Localidad: </b> Concordia
                                            <b class="mx-2 rounded-2">CUIT: </b> 20-38926571-6
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row border-bottom border-secondary w-95"></div>
                            <div class="d-flex align-items-start w-100 flex-column mt-3">
                                <div class="w-100 d-flex justify-content-center">
                                    Documento no valido como Factura
                                </div>
                                <h5 class="ms-5">Cliente</h5>
                                <div class="px-5 d-flex w-100 justify-content-between pb-4">
                                    <div class="w-30">
                                        <?php echo '<b class="me-3">Señor/a(es/as):</b>' . $nombreCliente ?>
                                    </div>
                                    <div class="w-30 d-flex justify-content-center">
                                        <?php echo '<b class="me-3">CUIT:</b> ' . $cliente['cuit'] ?>
                                    </div>
                                    <div class="w-30 d-flex justify-content-end">
                                        <div>
                                            <?php echo '<b class="me-3">I.V.A:</b> ' . $cliente['categoriafiscal'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 px-5">
                                <table class="text-center w-100 border-dark">
                                    <tr class="cabecera-grilla__backgrond">
                                        <th class="border border-1 border-dark">Nombre</th>
                                        <th class="border border-1 border-dark">Marca</th>
                                        <th class="border border-1 border-dark">Detalle</th>
                                        <th class="border border-1 border-dark">Cantidad</th>
                                        <th class="border border-1 border-dark">Precio unitario</th>
                                        <th class="border border-1 border-dark">Importe</th>
                                    </tr>
                                    <?php foreach ($productosPre as $productoPre) { ?>
                                        <tr class="grilla__cuerpo">
                                            <td class="border border-1 border-dark">
                                                <?php echo $productoPre['nombre']; ?>
                                            </td>
                                            <td class="border border-1 border-dark">
                                                <?php echo $productoPre['marca']; ?>
                                            </td>
                                            <td class="border border-1 border-dark">
                                                <?php echo $productoPre['detalle']; ?>
                                            </td>
                                            <td class="border border-1 border-dark">
                                                <?php echo $productoPre['cantidad']; ?>
                                            </td>
                                            <td class="border border-1 border-dark">
                                                <?php echo '$' . number_format($productoPre['precioventa'], 2); ?>
                                            </td>
                                            <td class="border border-1 border-dark">
                                                <?php echo '$' . number_format($productoPre['total'], 2); ?>
                                            </td>
                                            <?php $total = $total + $productoPre['total']; ?>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <div class="d-flex w-100 justify-content-end pt-4">
                                    <h4>Total:
                                        <?php echo '$' . number_format($total, 2); ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center headerPop__background">
                        <button type="button" class="btn button" data-bs-dismiss="modal">Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php echo $action == 'see' ? '<script> mostrarVentanaModal("ver"); </script>' : '' ?>
<?php echo $action == 'annul' ? '<script> mostrarVentanaModal("annul"); </script>' : '' ?>
<script>clickBorrarBusqueda();</script>

</html>
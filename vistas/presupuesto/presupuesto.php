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

            <div class="grilla w-95 d-flex flex-column align-items-center rounded-4">

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
        <?php if ($action == "see") {
            include_once 'vistas/otros/popUpComprobante.php';
        } ?>
    </main>
</body>
<?php echo $action == 'see' ? '<script> mostrarVentanaModal("ver"); </script>' : ''; ?>
<?php echo $action == 'annul' ? '<script> mostrarVentanaModal("annul"); </script>' : ''; ?>
<script>clickBorrarBusqueda();</script>

</html>
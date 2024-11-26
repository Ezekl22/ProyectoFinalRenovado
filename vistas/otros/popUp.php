<div class="modal fade" id="<?php echo $popUpM->getId(); ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div <?php echo $popUpM->getId() == "grillaProductos" ? "class='modal-dialog justify-content-center d-flex' style='max-width:none;'" : "class='modal-dialog '" ?>>
        <form action=" <?php echo $popUpM->getAccion(); ?>" method="POST" onsubmit="return validarFormulario()">
            <div class="modal-content" <?php echo $popUpM->getId() == "grillaProductos" ? "style='width:80vw;'" : "" ?>>
                <div class="modal-header headerPop__background">
                    <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo"
                        alt="logo de integral Service">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">
                        <?php echo $popUpM->getTitulo(); ?>
                    </h2>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php if ($popUpM->getId()) { ?>
                    <div class="modal-body d-flex flex-column align-items-center">
                        <!-- <div id="mensaje-error" class="text-danger"><?php echo $mensajeError; ?></div> -->
                        <?php switch ($popUpM->getId()) {
                            case 'inicioSesion':
                                ?>
                                <input id="mail" type="email" class="mb-4 mx-5 form-control w-75" name="mail" placeholder="Mail"
                                    required>
                                <input type="text" id="contrasena" name="contrasena" class="mx-5 form-control w-75"
                                    placeholder="Contraseña" required>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-link btn__recuperarC" data-bs-dismiss="modal"
                                        aria-label="Close" data-bs-toggle="modal" data-bs-target="#recuperarCon">
                                        Recuperar contraseña
                                    </button>
                                </div>
                                <?php break;
                            case 'recuperarCon': ?>
                                <div class="d-flex mb-4 mx-5">Ingrese su correo electrónico y recibirá un código de verificación.
                                </div>
                                <input type="email" class="mb-4 mx-5 form-control w-75" placeholder="mail" required>
                                <?php break;
                            case 'ingCodigo': ?>
                                <div class="d-flex mb-4 mx-5">Ingrese el codigo que se envio a su correo.</div>
                                <input type="text" class="mx-5 mb-4" placeholder="Código" required>
                                <?php break;
                            case 'nuevaCont': ?>
                                <div class="d-flex mb-4 mx-5">Ingrese la nueva contraseña.</div>
                                <input type="password" class="mx-5 mb-4" placeholder="Nueva contraseña" required>
                                <input type="password" class="mx-5 mb-4" placeholder="Repita la contraseña" required>
                                <?php break;
                            case 'delete': ?>
                                <label class="mb-4 mx-5">
                                    ¿Esta seguro/a que desea eliminar el elemento seleccionado?
                                </label>
                                <?php break;
                            case 'annul': ?>
                                <label class="mb-4 mx-5">
                                    ¿Esta seguro/a que desea anular el elemento seleccionado?
                                </label>
                                <?php break;
                            case 'grillaProductos': ?>
                                <div class="modal-body d-flex flex-column align-items-center" id="contGrillaProducto"></div>
                                <?php
                                break;
                            default:
                                ?>
                                <div id="mensaje-error" class="text-danger">ERROR: debe ingresar el body del popup</div>
                                <?php break;
                        } ?>
                    </div>
                <?php } ?>
                <div class="modal-footer d-flex justify-content-center headerPop__background">
                    <?php
                    foreach ($popUpM->getbotones() as $boton) {
                        switch ($boton['tipo']) {
                            case 'button':
                                ?>
                                <button type="button" class="btn button me-5" aria-label="Close" data-bs-dismiss="modal" <?php echo isset($boton['onclick']) ? 'onclick="' . $boton['onclick'] . '"' : ''; ?>>
                                    <?php echo $boton['texto']; ?>
                                </button>
                                <?php
                                break;
                            case 'a':
                                ?>
                                <a aria-label="Close" class="btn button " href="<?php echo $boton['href']; ?>">
                                    <?php echo $boton['texto']; ?>
                                </a>
                                <?php
                                break;
                            case 'submit':
                                ?>
                                <input class="btn button" type="submit" value="<?php echo $boton['texto']; ?>">
                                <?php
                                break;
                        }
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>
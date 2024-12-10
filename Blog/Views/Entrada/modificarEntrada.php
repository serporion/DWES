
<div class = "container">
    <h1>Editar Entrada</h1>
    <div class = "col-md-12 well">
        <form role = "form" id = "myForm" action = "<?=BASE_URL?>Entrada/guardarEntrada" method = "post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $mi_entrada->getId() ?>" >
            <input type="hidden" name="categoria_id" value="<?= $mi_entrada->getCategoriaId() ?>" >


            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" aria-describedby="tituloHelp" minLength = "5" value="<?= htmlspecialchars($mi_entrada->getTitulo()) ?>" required = "true">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= htmlspecialchars($mi_entrada->getDescripcion()) ?>" required = "true">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
            <a class="btn btn-primary" href="<?=BASE_URL?>Dashboard/index">Cancelar</a>
        </form>
    </div>
</div>

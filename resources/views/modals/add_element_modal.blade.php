<!-- Modal -->
<div id="newElement" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content

    precio, nombre, imagen, descripciòn, tipo de moneda

  -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Añadir un elemento</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-md-6">
                <input name="element_name" placeholder="Nombre" style="100%">
                <input name="element_price" placeholder="Precio" style="100%">
                <input type='file' id="imgInp_menu"/>
                <textarea name="element_description" placeholder="Descripción" style="100%"></textarea>
            </div>
            <div class="col-md-6"></div>
              <img id="img_preview_menu" src="#" alt="Preview" style="width:250px;"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-primary">Guardar</button>
        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>
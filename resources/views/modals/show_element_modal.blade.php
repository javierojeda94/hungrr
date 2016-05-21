<!-- Modal -->
<div id="showElement" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="element-title" class="modal-title">he</h4>
      </div>
        {!! Form::open(['route' => 'element.update','class' => 'form','files' => true]) !!}
        <div class="modal-body row">
          <div class="col-md-6">
            <label>Precio: </label> <p id="element-price"></p>
            <label>Descripción: </label> <p id="element-description"></p>
          </div>
          <div class="col-md-6">
            <img id="img_preview_menu"  src="../../images/placeholder3.png" alt="Preview" style="max-width: 250px;max-height: 187.5px; "/>
          </div>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
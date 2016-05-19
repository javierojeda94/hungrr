<!-- Modal -->
<div id="updateMenu" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar menú</h4>
      </div>
        {!! Form::open(['route' => 'menus.update','class' => 'form']) !!}
        <div class="modal-body">
          {!! Form::hidden('id', '', ['id' => 'menu-id','class' => 'menu-id']) !!}
          {!! Form::text('name', '', ['id' => 'name','class' => 'form-control name',  'placeholder'=>'p.e: Menú regular, menú de niños, etc.', 'style'=>'width:100%;']) !!}
        </div>
        <div class="modal-footer">
            {{ Form::submit('Guardar', array('class' => 'btn btn-primary')) }}
            <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
          {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- Modal -->
<div id="newSection" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Añadir sección</h4>
      </div>
      {!! Form::open(['route' => 'section.store','class' => 'form']) !!}
      <div class="modal-body">
        {!! Form::hidden('id', '', ['id' => 'menu-id','class' => 'menu-id']) !!}
        {!! Form::text('name', '', ['id' => 'name','class' => 'form-control',  'placeholder'=>'p.e: Desayunos, Bebidas, etc.', 'style'=>'width:100%;']) !!}
      </div>
      <div class="modal-footer">
        {{ Form::submit('Guardar', array('class' => 'btn btn-primary')) }}
        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
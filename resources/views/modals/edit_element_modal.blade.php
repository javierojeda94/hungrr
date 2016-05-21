<!-- Modal -->
<div id="updateElement" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar elemento</h4>
      </div>
        {!! Form::open(['route' => 'element.update','class' => 'form','files' => true]) !!}
        <div class="modal-body row">
          <div class="col-md-6">
            {!! Form::hidden('id', '', ['required','id' => 'element-id','class' => 'element-id']) !!}
            {!! Form::text('name', '', ['required','id' => 'element-name','class' => 'form-control name',  'placeholder'=>'Nombre', 'style'=>'width:100%; margin-bottom:10px']) !!}
            {!! Form::text('price', '', ['required','id' => 'element-price','class' => 'form-control price',  'placeholder'=>'Precio p.e: 100, 230, etc.', 'style'=>'width:100%;margin-bottom:10px']) !!}
            {!! Form::select('type', array('bebida'=>'Bebida', 'comida'=>'Comida', 'complemento'=>'Complemento', 'postre'=>'Postre'),'', array('required','id' => 'type','class' => 'form-control', 'style'=>'width:100%;margin-bottom:10px')) !!}
            {!! Form::textarea('description', '', ['required','id' => 'element-description','size' => '30x4','maxlength'=>'50','class' => 'form-control description',  'placeholder'=>'Descripción', 'style'=>'width:100%;margin-bottom:10px']) !!}
            {!! Form::file('image', array('id'=>'imgInp_menu')) !!}
          </div>
          <div class="col-md-6">
            <img id="img_preview_menu"  src="../../images/placeholder3.png" alt="Preview" style="max-width: 250px;max-height: 187.5px; "/>
          </div>
        </div>
        <div class="modal-footer">
          {{ Form::submit('Guardar', array('class' => 'btn btn-primary')) }}
          <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
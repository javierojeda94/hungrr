<!-- Modal -->
<div id="sendMessage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Enviar mensaje a @soporte</h4>
      </div>
        <div class="modal-body" >
          <h1>Contacto</h1>
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>

          {!! Form::open(array('route' => 'contact_store', 'class' => 'form')) !!}

          <div class="form-group">
            {!! Form::textarea('message', null,
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Mensaje')) !!}
          </div>
        </div>
        <div class="modal-footer">
          <div class="form-group">
            {!! Form::submit('Enviar mensaje',
              array('class'=>'btn btn-primary')) !!}
          </div>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>
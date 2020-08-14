{!! Form::open( array('id'=>'frm_updAgenda', 'action'=>'eventosController@update') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="update">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Alterar Evento</span>
            </div>

            <div class="modal-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-12">
                        <input name="u_id_evento"  id="u_id_evento" value="" type="hidden"></input>                
                        {!! Form::label("u_title", "Título/Descrição", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("u_title",  null, ["class"=>"form-control", "maxLength=255", "onkeydown"=>"setFocus(event,'#u_id_usuario');" ]) !!}
                        @if ($errors->has('u_title'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_title') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5">
                        {!! Form::label("u_id_usuario", "Usuário", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("u_id_usuario", $usuariosCombo, null, ['placeholder'=>'Selecione o Usuário', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_empresa');" ]) !!}
                        @if ($errors->has('u_id_usuario'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_id_usuario') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-4">
                        {!! Form::label("u_empresa", "Empresa Principal", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("u_empresa", $empresasCombo, null, ['placeholder'=>'Selecione a Empresa', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_status');" ]) !!}
                        @if ($errors->has('u_empresa'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_empresa') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("u_status","Status?",["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select('u_status', ['1'=>'Confirmado','0'=>'A Confirmar'], "1", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#u_start');" ]) !!}
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("u_start","Data Inicial", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::date("u_start", now() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_end');" ]) !!}
                        @if ($errors->has('u_start'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_start') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("u_end","Data Final", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::date("u_end", now() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_tipo_trabalho');" ]) !!}
                        @if ($errors->has('u_end'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_end') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5 offset-md-1">
                        {!! Form::label("u_tipo_trabalho", "Tipo de Agenda", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("u_tipo_trabalho", $tipoAgendaCombo, null, ['placeholder'=>'Selecione o Tipo', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#update-conf-btn');" ]) !!}
                        @if ($errors->has('u_tipo_trabalho'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_tipo_trabalho') }}
                            </span>
                        @endif
                        </div>

                    </div>
                </div>  
            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="update-conf-btn" onclick='javascript:$("#frm_updAgenda").submit();'>Salvar</button>

                <form id="frm_delAgenda" action="{{ url('eventos/delete') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input name="id_evento"  id="id_evento" value="" type="hidden"></input>                
                    <button type="button" class="btn btn-sm btn-secondary" id="delete-btn" href="#delete" data-toggle="modal">Deletar</button>
                </form>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

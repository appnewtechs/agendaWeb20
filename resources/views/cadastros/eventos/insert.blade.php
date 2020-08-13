{!! Form::open( array('id'=>'frm_incAgenda', 'action'=>'eventosController@create') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="insert">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir Evento</span>
            </div>

            <div class="modal-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-12">
                        {!! Form::label("i_title", "Título/Descrição", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("i_title",  null,     ["class"=>"form-control", "maxLength=255", "onkeydown"=>"setFocus(event,'#i_id_usuario');" ]) !!}
                        @if ($errors->has('i_title'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_title') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5">
                        {!! Form::label("i_id_usuario", "Usuário", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("i_id_usuario", $usuariosCombo, null, ['placeholder'=>'Selecione o Usuário', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_empresa');" ]) !!}
                        @if ($errors->has('i_id_usuario'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_id_usuario') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-4">
                        {!! Form::label("i_empresa", "Empresa Principal", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("i_empresa", $empresasCombo, null, ['placeholder'=>'Selecione a Empresa', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_status');" ]) !!}
                        @if ($errors->has('i_empresa'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_empresa') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("i_status","Status?",["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select('i_status', ['1'=>'Confirmado','0'=>'A Confirmar'], "1", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#i_start');" ]) !!}
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("i_start","Data Inicial", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::date("i_start", now() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_end');",
                            "onfocusout"=>"$('#i_end').val( $('#i_start').val() );" ]) !!}
                        @if ($errors->has('i_start'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_start') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("i_end","Data Final", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::date("i_end", now() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_tipo_trabalho');" ]) !!}
                        @if ($errors->has('i_end'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_end') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5 offset-md-1">
                        {!! Form::label("i_tipo_trabalho", "Tipo de Agenda", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("i_tipo_trabalho", $tipoAgendaCombo, null, ['placeholder'=>'Selecione o Tipo', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                        @if ($errors->has('i_tipo_trabalho'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_tipo_trabalho') }}
                            </span>
                        @endif
                        </div>

                    </div>
                </div>  
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal" onclick='javascript:location.reload();'>Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='javascript:$("#frm_incAgenda").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

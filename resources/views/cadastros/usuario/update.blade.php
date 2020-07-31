{!! Form::open( array('id'=>'frm_updUsuario', 'action'=>'usuarioController@update') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="update">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Alterar Usuário</span>
            </div>

            <div class="modal-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-6">
                        <input name="u_id_usuario"  id="u_id_usuario" value="" type="hidden"></input>                
                        {!! Form::label("u_nome", "Nome", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("u_nome",  null,   ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_telefone');" ]) !!}
                        @if ($errors->has('u_nome'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_nome') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-2">
                        {!! Form::label("u_telefone", "Telefone", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("u_telefone",  null,       ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_data_nascimento');" ]) !!}
                        @if ($errors->has('u_telefone'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_telefone') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-2">
                        {!! Form::label("u_data_nascimento","Data Nasc.", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::date("u_data_nascimento", now() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_status');" ]) !!}
                        </div>

                        <div class="col-md-2">
                        {!! Form::label("u_status","Status?",["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select('u_status', ['0'=>'Ativo','1'=>'Inativo'], "0", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#u_login');" ]) !!}
                        </div>

                    </div>

                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-3">
                        {!! Form::label("u_login", "Login", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("u_login",     null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_id_empresa');" ]) !!}
                        @if ($errors->has('u_login'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_login') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-4">
                        {!! Form::label("u_id_empresa", "Empresa Principal", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("u_id_empresa", $empresasCombo, null, ['placeholder'=>'Selecione a Empresa', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_email');" ]) !!}
                        @if ($errors->has('u_id_empresa'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_id_empresa') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5">
                        {!! Form::label("u_email", "E-mail Principal", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::email("u_email",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_id_perfil');",
                            "onfocusout"=>"preencherEmail('update');" ]) !!}
                        @if ($errors->has('u_email'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_email') }}
                            </span>
                        @endif
                        </div>


                        <div class="col-md-3">
                        {!! Form::label("u_id_perfil",  "Perfil", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("u_id_perfil", $perfisCombo, null, ['placeholder'=>'Selecione o Perfil', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_id_linha_produto');" ]) !!}
                        @if ($errors->has('u_id_perfil'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_id_perfil') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("u_id_linha_produto", "Linha de Serviço/Atuação", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("u_id_linha_produto", $tipoServicoCombo, null, ['placeholder'=>'Selecione a Linha de Serviço', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_especialidade');" ]) !!}
                        @if ($errors->has('u_id_linha_produto'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('u_id_linha_produto') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("u_especialidade", "Especialidade", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("u_especialidade",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#update-conf-btn');" ]) !!}
                        </div>

                    </div>
                </div>  


                <div class="dropdown-divider"></div>
                <div class="row">
                    <div class="col-md-12 border border-dark rounded pl-0 pr-0 pt-0 pb-0">
                        <table id="empresas" class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Empresa</th>
                                <th>E-mail</th>
                            </tr>
                            </thead>

                            <tbody>     
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="update-canc-btn" data-dismiss="modal" onclick='javascript:location.reload();'>Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="update-conf-btn" onclick='javascript:$("#frm_updUsuario").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

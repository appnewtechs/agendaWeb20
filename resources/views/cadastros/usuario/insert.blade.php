{!! Form::open( array('id'=>'frm_incUsuario', 'action'=>'usuarioController@create') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="insert">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir Usuário</span>
            </div>

            <div class="modal-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-6">
                        {!! Form::label("i_nome", "Nome", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("i_nome",  null,   ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_telefone');" ]) !!}
                        @if ($errors->has('i_nome'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_nome') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-2">
                        {!! Form::label("i_telefone", "Telefone", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("i_telefone",  null,       ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_data_nascimento');" ]) !!}
                        @if ($errors->has('i_telefone'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_telefone') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-2">
                        {!! Form::label("i_data_nascimento","Data Nasc.", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::date("i_data_nascimento", now() ,["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_status');" ]) !!}
                        </div>

                        <div class="col-md-2">
                        {!! Form::label("i_status","Status?",["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select('i_status', ['0'=>'Ativo','1'=>'Inativo'], "0", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#i_login');" ]) !!}
                        </div>

                    </div>

                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-3">
                        {!! Form::label("i_login", "Login", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("i_login",     null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_id_empresa');" ]) !!}
                        @if ($errors->has('i_login'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_login') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-4">
                        {!! Form::label("i_id_empresa", "Empresa Principal", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("i_id_empresa", $empresasCombo, null, ['placeholder'=>'Selecione a Empresa', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_email');" ]) !!}
                        @if ($errors->has('i_id_empresa'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_id_empresa') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5">
                        {!! Form::label("i_email", "E-mail Principal", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::email("i_email",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_id_perfil');",
                            "onfocusout"=>"preencherEmail();" ]) !!}
                        @if ($errors->has('i_email'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_email') }}
                            </span>
                        @endif
                        </div>


                        <div class="col-md-3">
                        {!! Form::label("i_id_perfil",  "Perfil", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("i_id_perfil", $perfisCombo, null, ['placeholder'=>'Selecione o Perfil', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_id_linha_produto');" ]) !!}
                        @if ($errors->has('i_id_perfil'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_id_perfil') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("i_id_linha_produto", "Linha de Serviço/Atuação", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("i_id_linha_produto", $tipoServicoCombo, null, ['placeholder'=>'Selecione a Linha de Serviço', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_especialidade');" ]) !!}
                        @if ($errors->has('i_id_linha_produto'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('i_id_linha_produto') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("i_especialidade", "Especialidade", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("i_especialidade",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                        </div>

                    </div>
                </div>  


                <div class="dropdown-divider"></div>
                <div class="row">
                    <div class="col-md-12 border border-dark rounded pl-0 pr-0 pt-0 pb-0">
                        <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Empresa</th>
                                <th>E-mail</th>
                            </tr>
                            </thead>

                            <tbody>     
                                @php ($numRows=1)
                                @foreach($empresas as $empresa)
                                <tr>
                                    <td>{{ $empresa->razao_social }}</td>
                                    <td><input name="i_arr_email[]"   id="i_arr_email"   type="email"  class="form-control inputrow"></input>
                                        <input name="i_arr_empresa[]" id="i_arr_empresa" type="hidden" value="{{ $empresa->id_empresa }}"></input>
                                    </td>                            
                                </tr>
                                @php ($numRows++)
                                @endforeach
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='javascript:$("#frm_incUsuario").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

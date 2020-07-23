{!! Form::open( array('id'=>'frm_altEmpresa', 'action'=>'empresaController@update') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="update">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 80vw;">
        <div class="modal-content" role='document'>

            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Alterar Empresa</span>
            </div>
            
            <div class="modal-body">
            <div class="form-row border border-dark rounded col-md-12 pl-4 pr-4 pt-1 pb-3 ml-0">

                <div class="col-md-6">
                <input name="u_codEmpresa"  id="u_codEmpresa" value="" type="hidden"></input>                
                {!! Form::label("u_razaoSocial","Razão Social",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_razaoSocial", null ,["class"=>"form-control", "maxLength=45", "onkeydown"=>"setFocus(event,'#u_nomeFantasia');" ]) !!}
                @if ($errors->has('u_razaoSocial'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_razaoSocial') }}
                    </span>
                @endif
                </div>

                <div class="col-md-6">
                {!! Form::label("u_nomeFantasia","Nome Fantasia",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('u_nomeFantasia', null, ["class"=>"form-control", "maxLength=45", "onkeydown"=>"setFocus(event,'#u_tipoPessoa');" ]) !!}
                @if ($errors->has('u_nomeFantasia'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_nomeFantasia') }}
                    </span>
                @endif
                </div>

                <div class="col-md-2">
                {!! Form::label("u_tipoPessoa","Tipo Empresa",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('u_tipoPessoa', ["1"=>"Pessoa Física","2"=>"Pessoa Jurídica"],  null, 
                    ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#u_cpfCNPJ');" ]) !!}
                    @if ($errors->has('u_tipoPessoa'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_tipoPessoa') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("u_cpfCNPJ","CPF/CNPJ",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_cpfCNPJ",  null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_enderecoEmpresa');" ]) !!}
                @if ($errors->has('u_cpfCNPJ'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_cpfCNPJ') }}
                    </span>
                @endif
                </div>

                <div class="col-md-7">
                {!! Form::label("u_enderecoEmpresa","Endereço",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_enderecoEmpresa", null, ["class"=>"form-control", "maxLength=90", "onkeydown"=>"setFocus(event,'#u_bairroEmpresa');" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("u_bairroEmpresa","Bairro",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('u_bairroEmpresa', null, ["class"=>"form-control", "maxLength=40", "onkeydown"=>"setFocus(event,'#u_codEstado');" ]) !!}
                </div>

                <div class="col-md-3">
                {!! Form::label("u_codEstado","UF",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('u_codEstado', [], null, ['class'=>'form-control', 
                    "onchange"=>"buscaCidades($('#update').find('#u_codEstado').val(), $('#update').find('#u_codMunicipio'))",
                    "onkeydown"=>"setFocus(event,'#u_codMunicipio');" ]) !!}
                </div>

                <div class="col-md-4">
                {!! Form::label("u_codMunicipio","Cidade", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('u_codMunicipio', [], null, ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#u_cepEmpresa');" ]) !!}
                </div>

                <div class="col-md-2">
                {!! Form::label("u_cepEmpresa","CEP",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_cepEmpresa", null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_contatoEmpresa');" ]) !!}
                @if ($errors->has('u_cepEmpresa'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_cepEmpresa') }}
                    </span>
                @endif
                </div>

                <div class="col-md-3">
                {!! Form::label("u_contatoEmpresa","Contato",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_contatoEmpresa", null, ["class"=>"form-control", "maxLength=15", "onkeydown"=>"setFocus(event,'#u_numeroTelefone');" ]) !!}
                @if ($errors->has('u_contatoEmpresa'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_contatoEmpresa') }}
                    </span>
                @endif
                </div>

                <div class="col-md-2">
                {!! Form::label("u_numeroTelefone","Telefone",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_numeroTelefone" , null, ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#update-conf-btn');" ]) !!}
                @if ($errors->has('u_numeroTelefone'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('u_numeroTelefone') }}
                    </span>
                @endif
                </div>
            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="update-canc-btn" data-dismiss="modal" onclick='javascript:location.reload();'>Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="update-conf-btn" onclick='javascript:$("#frm_altEmpresa").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}


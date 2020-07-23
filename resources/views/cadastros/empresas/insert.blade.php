{!! Form::open( array('id'=>'frm_incEmpresa', 'action'=>'empresaController@create') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="insert">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>

            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir nova Empresa</span>
            </div>

            <div class="modal-body">
            <div class="form-row required border border-dark rounded col-md-12 pl-5 pr-5 pt-1 pb-3 ml-0">

                <div class="col-md-6">
                {!! Form::label("i_razaoSocial","Razão Social",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_razaoSocial",  null ,["class"=>"form-control", "maxLength=45", "onkeydown"=>"setFocus(event,'#i_nomeFantasia');" ]) !!}
                @if ($errors->has('i_razaoSocial'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_razaoSocial') }}
                    </span>
                @endif
                </div>

                <div class="col-md-6">
                {!! Form::label("i_nomeFantasia","Nome Fantasia",["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text('i_nomeFantasia',  null, ["class"=>"form-control", "maxLength=45", "onkeydown"=>"setFocus(event,'#u_tipoPessoa');" ]) !!}
                @if ($errors->has('i_nomeFantasia'))
                    <span colspan='12' style="color: red;">
                        {{ $errors->first('i_nomeFantasia') }}
                    </span>
                @endif
                </div>

            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='javascript:$("#frm_incEmpresa").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}


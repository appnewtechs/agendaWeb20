{!! Form::open( array('id'=>'frm_altModoVenda', 'action'=>'modosVendaController@update') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="update">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Alterar Modo de Venda</span>
            </div>


            <div class="modal-body">
            <div class="form-row border border-dark rounded col-md-12 pl-5 pr-5 pt-1 pb-3 ml-0">
                    
                <div class="col-md-1">
                {!! Form::label("u_codModalidade", "Código", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_codModalidade" , null,     ["class"=>"form-control", "readonly"]) !!}
                </div>

                <div class="col-md-9">
                {!! Form::label("u_descModalidade", "Descrição", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("u_descModalidade",  null,        ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#u_eCommerce');" ]) !!}
                </div>

                <div class="col-md-2">
                {!! Form::label("u_eCommerce","Venda OnLine?", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('u_eCommerce',['N'=>'Não','S'=>'Sim'], null, ['class'=>'form-control',  "onkeydown"=>"setFocus(event,'#update-conf-btn');" ]) !!}
                </div>

            </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="update-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="update-conf-btn" onclick='javascript:$("#frm_altModoVenda").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}


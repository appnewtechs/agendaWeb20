{!! Form::open( array('id'=>'frm_incModoVenda', 'action'=>'modosVendaController@create') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="insert">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir Modo de Venda</span>
            </div>

            <div class="modal-body">
            <div class="form-row border border-dark rounded col-md-12 pl-5 pr-5 pt-1 pb-3 ml-0">
                    
                <div class="col-md-10">
                {!! Form::label("i_descModalidade", "Descrição", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::text("i_descModalidade",  null,        ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#i_eCommerce');" ]) !!}
                </div>

                <div class="col-md-2">
                {!! Form::label("i_eCommerce","Venda OnLine?", ["class"=>"col-form-label pl-0"]) !!}
                {!! Form::select('i_eCommerce',['N'=>'Não','S'=>'Sim'], null, ['class'=>'form-control',  "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                </div>

            </div>  
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='javascript:$("#frm_incModoVenda").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

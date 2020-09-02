<div class="modal fade" id="modalAgenda">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title"></span>
            </div>

            <div class="modal-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    {!! Form::open( array('id'=>'frm_agenda') ) !!}
                    {{ csrf_field() }}

                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-12">
                        <input name="id_evento"  id="id_evento" value="" type="hidden"></input>                
                        {!! Form::label("title", "Título/Descrição", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("title",  null,     ["class"=>"form-control", "maxLength=255", "onkeydown"=>"setFocus(event,'#id_usuario');" ]) !!}
                        @if ($errors->has('title'))
                            <span colspan='12' style="color: red;">
                            {{ $errors->first('title') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-5">
                        {!! Form::label("id_usuario", "Usuário", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("id_usuario", $usuariosCombo, null, ['placeholder'=>'Selecione o Usuário', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#empresa');" ]) !!}
                        @if ($errors->has('id_usuario'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('id_usuario') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-4">
                        {!! Form::label("empresa", "Empresa Principal", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("empresa", $empresasCombo, null, ['placeholder'=>'Selecione a Empresa', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#status');" ]) !!}
                        @if ($errors->has('empresa'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('empresa') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-3">
                        {!! Form::label("status","Status?",["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select('status', ['1'=>'Confirmado','0'=>'A Confirmar'], "1", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#tipo_trabalho');" ]) !!}
                        </div>


                        <div class="col-md-6">

                            {!! Form::label("datas", "Seleção de Datas", ["class"=>"col-form-label pl-0"]) !!}
                            <br>
                            <div class="row pt-1">
                                <div class="col-md-6">
                                    <label class="radio">
                                        <input type="radio" name="dataSelecao" id="radio1" value="2" onChange="$('#datasSelecionadas tr').remove();" checked> Intervalo</input>
                                    </label>
                                </div>
                            
                                <div class="col-md-6">
                                    <label class="radio inline">
                                    <input type="radio" name="dataSelecao" id="radio2" value="1" onChange="$('#datasSelecionadas tr').remove();"> Múltiplas Datas</input>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 offset-md-1">
                        {!! Form::label("tipo_trabalho", "Tipo de Agenda", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select("tipo_trabalho", $tipoAgendaCombo, null, ['placeholder'=>'Selecione o Tipo', 
                            "class"=>"form-control", "onkeydown"=>"setFocus(event,'#confirm-btn');" ]) !!}
                        @if ($errors->has('tipo_trabalho'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('tipo_trabalho') }}
                            </span>
                        @endif
                        </div>

                    </div>


                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div id="datepicker" class="col-md-6">

                        </div>
                        <div class="col-md-4 offset-md-1">
                            <br>
                            <div class="row">
                                {!! Form::label("datasBox", "Datas Selecionadas", ["class"=>"col-form-label pl-0"]) !!}
                                <div class="col-md-12 border border-dark rounded pl-0 pr-0 pt-0 pb-0">
                                <table id="datasSelecionadas" class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                                    <tbody>     
                                    </tbody>
                                </table>
                                </div>  
                                @if ($errors->has('dataSel'))
                                    <span colspan='12' style="color: red;">
                                        {{ $errors->first('dataSel') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>  
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger"    id="delete-btn"  href="#delete" data-toggle="modal">Excluir</button>
                <button type="button" class="btn btn-sm btn-secondary" id="cancel-btn"  data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="confirm-btn" data-dismiss="modal" onClick="$('#frm_agenda').submit();">Salvar</button>
            </div>
        </div>
    </div>
</div>


<script type='text/javascript'>

    $(document).ready(function(){

        $('#datepicker').datepicker({
            dateFormat: "dd/mm/yy",
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Proximo',
            prevText: 'Anterior',
            onSelect: function(selected,evnt) {

                var tableSel  = document.getElementById("datasSelecionadas");
                var qtdeDatas = tableSel.getElementsByTagName("tr") ;
                var intervalo = $("#radio1").is(":checked"); 
                var multipla  = $("#radio2").is(":checked"); 
                var repetida  = false;
                var newRow    = '';
                

                $("input[name='dataSel[]']").each(function(){ 
                    if ($(this).val()==selected) {
                        repetida = true;
                        return false; 
                    }
                });

                if (!repetida) {
    
                    if ( (intervalo && qtdeDatas.length<=1) || multipla ){
                        newRow =  '<tr>';
                        newRow += '<td><input name="dataSel[]" id="dataSel" value="'+selected+'"  type="text" class="form-control inputrow" readonly></input></td>';
                        newRow += '<td><a class="fas fa-eraser" title="Deletar" href="#" onclick="excluirData(this.parentNode.parentNode.rowIndex);"></a></td>';
                        newRow += '</tr>';
                        $('#datasSelecionadas tbody').append(newRow);    
                    };
                };
            }
        }).datepicker("setDate", new Date());


    });

</script>

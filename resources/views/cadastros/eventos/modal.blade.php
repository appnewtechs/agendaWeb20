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


                    <div class="form-row col-md-12 pl-0 pr-0">

                        <div class="form-row col-md-7 pl-0 pr-1">

                            <div class="col-md-12">
                            <input name="id_evento"  id="id_evento" value="" type="hidden"></input>                
                            {!! Form::label("title", "Título/Descrição", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::text("title",  null,     ["class"=>"form-control", "maxLength=255", "onkeydown"=>"setFocus(event,'#status');" ]) !!}
                            </div>

                            <div class="col-md-4">
                            {!! Form::label("status","Status?",["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select('status', ['1'=>'Confirmado','0'=>'A Confirmar'], "1", ['class'=>'form-control', "onkeydown"=>"setFocus(event,'#id_usuario');" ]) !!}
                            </div>

                            <div class="col-md-8">
                            {!! Form::label("id_usuario", "Usuário", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("id_usuario", $usuariosCombo, null, ['placeholder'=>'Selecione o Usuário', 
                                "class"=>"form-control", "onkeydown"=>"setFocus(event,'#empresa');" ]) !!}
                            </div>

                            <div class="col-md-5">
                            {!! Form::label("empresa", "Empresa Principal", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("empresa", $empresasCombo, null, ['placeholder'=>'Selecione Empresa', 
                                "class"=>"form-control", "onkeydown"=>"setFocus(event,'#tipo_trabalho');" ]) !!}
                            </div>

                            <div class="col-md-7">
                            {!! Form::label("tipo_trabalho", "Tipo de Agenda", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::select("tipo_trabalho", $tipoAgendaCombo, null, ['placeholder'=>'Selecione o Tipo', 
                                "class"=>"form-control", "onkeydown"=>"setFocus(event,'#confirm-btn');" ]) !!}
                            </div>


                            <div class="col-md-10">
                                {!! Form::label("datas", "Seleção de Datas", ["class"=>"col-form-label pl-0"]) !!}
                                <br>
                                <div class="row pt-1">
                                    <div class="col-md-6">
                                        <label class="radio">
                                            <input type="radio" name="dataSelecao" id="radio1" value="2" checked
                                             onChange="selecaoDatas(2);"> Intervalo</input>
                                        </label>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <label class="radio inline">
                                        <input type="radio" name="dataSelecao" id="radio2" value="1" 
                                        onChange="selecaoDatas(999);"> Múltiplas Datas</input>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                            {!! Form::label("datas", "Datas Selecionadas", ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::text("datas",  null,     ["class"=>"form-control", "readonly"]) !!}
                            </div>


                        </div>



                        <div class="form-row col-md-5 pt-0 pr-0">
                            <div id="datepicker" class="col-md-12"></div>
                        </div>
                    </div>



                    {!! Form::close() !!}

                </div>  
            </div>

            <div class="modal-footer">
                <span colspan='10' id='erros' style="color: red; font-weight: bold; padding-right: 2rem;"></span>
                <button type="button" class="btn btn-sm btn-danger"    id="delete-btn"  href="#delete" data-toggle="modal">Excluir</button>
                <button type="button" class="btn btn-sm btn-secondary" id="cancel-btn"  data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="confirm-btn" onClick="gravaAgenda();">Salvar</button>
            </div>
        </div>
    </div>
</div>



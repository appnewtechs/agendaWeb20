{!! Form::open( array('id'=>'frm_incPerfil', 'action'=>'perfilUsuarioController@create') ) !!}
{{ csrf_field() }}

<div class="modal fade" id="insert">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir Perfil de Usuário</span>
            </div>

            <div class="modal-body">
            <div class="row">    

                <div class="col-md-8 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    <div class="col-md-12">
                    {!! Form::label("nome", "Nome", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::text("nome",  null,   ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#descricao');" ]) !!}
                    </div>

                    <div class="col-md-12">
                    {!! Form::label("descricao", "Descrição", ["class"=>"col-form-label pl-0"]) !!}
                    {!! Form::text("descricao",  null,        ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#insert-conf-btn');" ]) !!}
                    </div>

                </div>  

                <div class="col-md-4 border border-dark rounded pl-0 pr-0 pt-0 pb-3">
                    <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                        <thead class="thead-dark">
                        <tr>
                            <th>Rotinas</th>
                            <th><input name="checkTodos" id="checkTodos" type="checkbox" 
                                class="form-control" onclick='markAllRotinas();' style="height: 17px; color:black;"></input></th>
                        </tr>
                        </thead>

                        <tbody>     
                            @foreach($testes as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td><input name="checkSel[]"  id="checkSel"   value="off" type="checkbox" class="form-control" style="height: 17px; color:black;"></input>
                                    <input name="codRotina[]" id="codRotina"  value="{{ $item->id_rotina }}" type="hidden"></input>
                                </td>                            
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
            </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='javascript:$("#frm_incPerfil").submit();'>Salvar</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

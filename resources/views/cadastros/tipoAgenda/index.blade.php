@extends('layouts.layoutPadrao')
@section('header')

    {!! Form::open(['method'=>'get']) !!}
    <nav class="navbar navbar-expand-sm navbar-light bg-light">    
        <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto font-weight-bold pl-2">
                <li><span class="linhaMestra">Tipos de Agenda</span></li>                
            </ul>

            <form class="form-inline my-2 my-lg-2">
            <ul class="navbar-nav input-group input-group-sm col-md-6">
                {!! Form::label("status" , "Status",["class"=>"col-form-label col-md-2 offset-md-2 text-right"]) !!}
                {!! Form::select('status', ['0'=>'Ativos', '1'=>'Inativos', '2'=>'Ambos'], request('status') ? request('status') :'0', 
                    ['class'=>'form-control col-md-2', 
                    'style'=>"border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;", 
                    "onchange"=>"$('#search_btn').click();" ]) !!}
                <div class="input-group-append col-md-6 pr-0">

                    <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" 
                    placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                    <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                    <input type="hidden" value="{{request('field')}}" id="field" name="field"/>
                    <input type="hidden" value="{{request('sort')}}"  id="sort"  name="sort"/>
                </div>
            </ul>
            </form>
        </div>
    </nav>
    {!! Form::close() !!}

@include('layouts.delete')
@endsection


@section('content')
<div id="main" class="container-fluid pt-2 pb-2">
    <div id="list" class="col-md-12 border border-dark rounded pb-0 pl-0 pr-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" href='#' onClick="tablesorter('id_trabalho');">Código</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('descricao');">Descrição</a></th>
                    <th>Cor</th>
                    <th class="text-right">Status</th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($tiposAgenda as $trabalho)
                    <tr>
                        <td>{{ $trabalho->id_trabalho }}</td>
                        <td>{{ $trabalho->descricao }}</td>
					    <td><div style="background-color: #{{ $trabalho->cor }}; padding: 10px;"></div></td>
                        <td class="text-right">{{ $trabalho->status=='1' ? "Inativo" : "Ativo" }}</td>
                        <td class="text-right" style="vertical-align: middle">

                            <form id="frm_del_tipoAgenda_{{ $trabalho->id_trabalho }}" method="post">

                                {{ csrf_field() }}
                                <input name="id_trabalho" id="id_trabalho" value="{{ $trabalho->id_trabalho }}" type="hidden"></input>                
                                <input name="status"      id="status"      value="{{ $trabalho->status }}"      type="hidden"></input>                

                                <a class="{{ $trabalho->status=='0' ? 'fas fa-thumbs-down' : 'fas fa-thumbs-up' }}"
                                   title="{{ $trabalho->status=='0' ? 'Inativar' : 'Ativar' }}" href="#" onclick="excluirTipo( 'status', {{json_encode($trabalho)}} );"></a>
                                <a class='fas fa-eraser' title="Deletar"  href="#" onclick="excluirTipo( 'delete', {{json_encode($trabalho)}} );"></a>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
</div> 

@include('layouts.footer')
@include('cadastros.tipoAgenda.insert')


<script type='text/javascript'>
    $(document).ready(function(){

        $('#search').focus();
        $('#insert').on('shown.bs.modal', function(e) {
            $('#insert').find("#descricao").focus();
        });

    });


    function excluirTipo(action, trabalho){

        if(action=='delete'){

            $('#frm_del_tipoAgenda_'+trabalho.id_trabalho).attr('action', "{{ url('tipoAgenda/delete') }}") 

            $('#delete').find("#delete-btn").html('Excluir');
            $('#delete').find("#modal-title").html('Exclusão de Registro!');
            $('#delete').find("#intro").html('Você tem certeza que deseja excluir o registro?');
        
        } else {

            $('#frm_del_tipoAgenda_'+trabalho.id_trabalho).attr('action', "{{ url('tipoAgenda/status') }}") 

            if(trabalho.status==0){

                $('#delete').find("#delete-btn").html('Inativar');
                $('#delete').find("#modal-title").html('Inativação de Registro!');
                $('#delete').find("#intro").html('Você tem certeza que deseja inativar o registro?');
            } else {
                $('#delete').find("#delete-btn").html('Ativar');
                $('#delete').find("#modal-title").html('Ativação de Registro!');
                $('#delete').find("#intro").html('Você tem certeza que deseja ativar o registro?');
            }
        }

        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_tipoAgenda_"+trabalho.id_trabalho+"').submit()");
        $('#delete').find("#description").html('Tipo de Agenda: '+trabalho.id_trabalho+' - '+trabalho.descricao);
        $('#delete').modal('show');
    };   

</script>
@endsection
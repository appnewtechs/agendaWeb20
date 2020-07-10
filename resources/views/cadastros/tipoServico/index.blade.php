@include('layouts.padraoMain')
{!! Form::open(['method'=>'get']) !!}
<nav class="navbar navbar-expand-lg navbar-light bg-light">    
    
    <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Tipo de Serviço</span></li>                
        </ul>

        <form class="form-inline my-2 my-lg-2">
        <ul class="navbar-nav input-group input-group-sm col-md-3">
    
            <div class="input-group">
                <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" 
                       placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                <div class="input-group-append">
                    <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                    <input type="hidden" value="{{request('field')}}" id="field" name="field"/>
                    <input type="hidden" value="{{request('sort')}}"  id="sort"  name="sort"/>
                </div>
            </div>
        </ul>
        </form>
    </div>
</nav>
{!! Form::close() !!}


<div id="main" class="container-fluid pt-2 pb-2">
<div class="row">
    <div id="list" class="col-md-12 border border-dark rounded pb-0 pl-0 pr-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" href='#' onClick="tablesorter('id_linha_produto');">Código</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('descricao');">Descrição</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($tiposServico as $tipo)
                    <tr>
                        <td>{{ $tipo->id_linha_produto }}</td>
                        <td>{{ $tipo->descricao }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_del_tipoServico_{{ $tipo->id_linha_produto }}" action="{{ url('tipoServico/delete') }}" method="post">

                            <input name="id_linha_produto" id="id_linha_produto" value="{{ $tipo->id_linha_produto }}" type="hidden"></input>                
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $tipo->id_linha_produto }}"
                                                                                                        data-descricao="{{ $tipo->descricao }}"></a>
                        </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
    </div> 
</div> 



@include('layouts.delete')
@include('layouts.footerPadrao')
@include('cadastros.tipoServico.insert')

<script type='text/javascript'>
$(document).ready(function(){

    $('#search').focus();
    document.getElementById("qtdeRegistros").textContent="Total Itens: {{ $tiposServico->count() }}";
    document.getElementById("valorTotal").textContent="";

    $('#insert').on('shown.bs.modal', function(e) {
        $('#insert').find("#descricao").focus();
    });


    $('#delete').on('show.bs.modal', function(e) {
        var codigo   = $(e.relatedTarget).data("codigo");
        var descricao= $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Tipo de Serviço: '+codigo+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_tipoServico_"+codigo+"').submit()");
    });   
});

</script>

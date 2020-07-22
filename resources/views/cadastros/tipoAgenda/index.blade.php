@include('layouts.padraoMain')
<script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2@2.0.0/dist/spectrum.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2@2.0.0/dist/spectrum.min.css">

{!! Form::open(['method'=>'get']) !!}
<nav class="navbar navbar-expand-lg navbar-light bg-light">    
    
    <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Tipo de Agenda</span></li>                
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


@if(Session::has('errors'))
<script type='text/javascript'>
    $(document).ready(function(){
        var nomeModal = "{{ Session('id_modal') }}";
        $('#'+nomeModal).modal('show');
    });
</script>
@endif


<div id="main" class="container-fluid pt-2 pb-2">
<div class="row">
    <div id="list" class="col-md-12 border border-dark rounded pb-0 pl-0 pr-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" href='#' onClick="tablesorter('id_trabalho');">Código</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('descricao');">Descrição</a></th>
                    <th>Cor</th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($tiposAgenda as $trabalho)
                    <tr>
                        <td>{{ $trabalho->id_trabalho }}</td>
                        <td>{{ $trabalho->descricao }}</td>
					    <td><div style="background-color: #{{ $trabalho->cor }}; padding: 10px;"></div></td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_del_tipoAgenda_{{ $trabalho->id_trabalho }}" action="{{ url('tipoAgenda/delete') }}" method="post">

                            <input name="id_trabalho" id="id_trabalho" value="{{ $trabalho->id_trabalho }}" type="hidden"></input>                
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $trabalho->id_trabalho }}"
                                                                                                        data-descricao="{{ $trabalho->descricao }}"></a>
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
@include('cadastros.tipoAgenda.insert')

<script type='text/javascript'>
$(document).ready(function(){

    $('#search').focus();
    document.getElementById("qtdeRegistros").textContent="Total Itens: {{ $tiposAgenda->count() }}";
    document.getElementById("valorTotal").textContent="";

    $('#color').spectrum({
            type: "component",
            showInput: "true",
            showAlpha: "false",
            showButtons: "false",
            allowEmpty: "false"
    });

    $('#insert').on('shown.bs.modal', function(e) {
        $('#insert').find("#descricao").focus();
    });


    $('#delete').on('show.bs.modal', function(e) {
        var codigo   = $(e.relatedTarget).data("codigo");
        var descricao= $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Tipo de Agenda: '+codigo+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_tipoAgenda_"+codigo+"').submit()");
    });   
});

</script>

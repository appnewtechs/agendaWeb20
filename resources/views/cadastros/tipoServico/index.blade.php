@extends('layouts.header')

@section('header-name','Tipos de Serviços')
@section('content')
<div id="main" class="container-fluid pt-2 pb-2">
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

@include('layouts.footer')
@include('cadastros.tipoServico.insert')

<script type='text/javascript'>
$(document).ready(function(){

    $('#search').focus();
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
@endsection

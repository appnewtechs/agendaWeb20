@extends('layouts.header')

@section('header-name','Tipo de Agenda')
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

@include('layouts.footer')
@include('cadastros.tipoAgenda.insert')

<script type='text/javascript'>
$(document).ready(function(){

    $('#search').focus();
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
@endsection
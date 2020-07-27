@extends('layouts.layoutPadrao')
@section('header')

    @include('layouts.erros')
    {!! Form::open(['method'=>'get']) !!}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">    
        <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto font-weight-bold pl-2">
                <li><span class="linhaMestra">Usuários</span></li>                
            </ul>

            <form class="form-inline my-2 my-lg-2">
            <ul class="navbar-nav input-group input-group-sm col-md-6">
                {!! Form::label("status" , "Status",["class"=>"col-form-label col-md-2 offset-md-2 text-right"]) !!}
                {!! Form::select('status', ['0'=>'Ativo', '1'=>'Inativo', '2'=>'Ambos'], request('status') ? request('status') :'0', 
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
<div id="main" class="container-fluid pt-2 pb-5">
    <div id="list" class="row border border-dark rounded pb-1" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped tablesorter mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" href='#' onClick="tablesorter('id_usuario'  );">Código</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('login'       );">Login</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('nome'        );">Nome</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('razao_social');">Empresa</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('linha_produto.descricao');">Tipo de Serviço/Atuação</a></th>
                    <th><a class="linktd">E-mail</a></th>
                    <th><a class="linktd">Telefone</a></th>
                    <th><a class="linktd">Status</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id_usuario }}</td>
                        <td>{{ $usuario->login }}</td>
                        <td>{{ $usuario->nome }}</td>
                        <td>{{ $usuario->razao_social }}</td>
                        <td>{{ $usuario->descricao }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->telefone }}</td>
                        <td>{{ $usuario->status=='1' ? "Inativo" : "Ativo" }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_del_usuario_{{ $usuario->id_usuario }}" action="{{ url('usuario/delete') }}" method="post">

                            <input name="id_usuario" id="id_usuario" value="{{ $usuario->id_usuario }}" type="hidden"></input>                
                            <a class='fas fa-edit'   title="Alterar" href="#update" data-toggle="modal" data-usuario ="{{ $usuario->id_usuario }}" 
                                                                                                        data-nome    ="{{ $usuario->nome  }}"
                                                                                                        data-email   ="{{ $usuario->email }}"
                                                                                                        data-status  ="{{ $usuario->status }}"
                                                                                                        data-empresa ="{{ $usuario->id_empresa }}"
                                                                                                        data-login   ="{{ $usuario->login }}"
                                                                                                        data-telefone ="{{ $usuario->telefone }}"
                                                                                                        data-perfil   ="{{ $usuario->id_perfil }}"
                                                                                                        data-datanasc ="{{ $usuario->data_nascimento }}"
                                                                                                        data-linhaprod  ="{{ $usuario->id_linha_produto }}"
                                                                                                        data-especialid ="{{ $usuario->especialidade }}"
                                                                                                        ></a>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $usuario->id_usuario }}"
                                                                                                        data-descricao="{{ $usuario->nome }}"></a>
                        </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
</div> 

@include('cadastros.usuario.insert')
@include('cadastros.usuario.update')


<script type='text/javascript'>
$(document).ready(function(){

    $('#u_telefone').mask('(00) 00000-0000');
    $('#search').focus();
   
    $('#insert').on('shown.bs.modal', function(e) {
        $("#i_nome").focus();
        $('#i_telefone').mask('(00) 00000-0000');
    });

    $('#update').on('shown.bs.modal', function(e) {

        var usuario  = "{{ old('u_id_usuario') }}"  ? "{{ old('u_id_usuario') }}"  : $(e.relatedTarget).data("usuario");
        var nome     = "{{ old('u_nome') }}"        ? "{{ old('u_nome') }}"        : $(e.relatedTarget).data("nome");
        var email    = "{{ old('u_email') }}"       ? "{{ old('u_email') }}"       : $(e.relatedTarget).data("email");
        var status   = "{{ old('u_status') }}"      ? "{{ old('u_status') }}"      : $(e.relatedTarget).data("status");
        var empresa  = "{{ old('u_id_empresa') }}"  ? "{{ old('u_id_empresa') }}"  : $(e.relatedTarget).data("empresa");
        var login    = "{{ old('u_login') }}"       ? "{{ old('u_login') }}"       : $(e.relatedTarget).data("login");
        var telefone = "{{ old('u_telefone') }}"    ? "{{ old('u_telefone') }}"    : $(e.relatedTarget).data("telefone");
        var perfil   = "{{ old('u_id_perfil') }}"   ? "{{ old('u_id_perfil') }}"   : $(e.relatedTarget).data("perfil");
        var datanasc   = "{{ old('u_data_nascimento') }}"    ? "{{ old('u_data_nascimento') }}"  : $(e.relatedTarget).data("datanasc");
        var linhaprod  = "{{ old('u_id_linha_produto') }}"   ? "{{ old('u_id_linha_produto') }}" : $(e.relatedTarget).data("linhaprod");
        var especialid = "{{ old('u_especialidade') }}"      ? "{{ old('u_especialidade') }}"    : $(e.relatedTarget).data("especialid");
        carregaEmpresas(usuario);

        var modal = $(this);
        modal.find('#u_id_usuario').val(usuario);
        modal.find('#u_nome').val(nome);
        modal.find('#u_email').val(email);
        modal.find('#u_status').val(status);
        modal.find('#u_id_empresa').val(empresa);
        modal.find('#u_login').val(login);
        modal.find('#u_telefone').val(telefone);
        modal.find('#u_id_perfil').val(perfil);
        modal.find('#u_data_nascimento').val(datanasc);
        modal.find('#u_id_linha_produto').val(linhaprod);
        modal.find('#u_especialidade').val(especialid);

        $("#u_nome").focus();
    });


    $('#delete').on('show.bs.modal', function(e) {
        var codigo   = $(e.relatedTarget).data("codigo");
        var descricao= $(e.relatedTarget).data("descricao");

        $('#delete').find("#description").html('Usuário: '+codigo+' - '+descricao);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_usuario_"+codigo+"').submit()");
    });   
});


function preencherEmail() {
    $("input[name='u_arr_empresa[]']").each(function(){
        i=$(this).val();
        codEmpresa = $("#u_arr_empresa"+i).val();
        if( codEmpresa==$('#u_id_empresa').val() ){
            $("#u_arr_email"+i).val( $('#u_email').val() );
        }
    });
}

function carregaEmpresas(usuario) {

    $(document).ready(function(){
        $.ajax({
            url: '/usuario/empresas/'+usuario,
            type: 'get',
            dataType: 'json',
            success: function(response){

                if(response.length > 0){
                    for(var i=0; i<response.length; i++){
                    
                        var email = response[i].email!=null ? response[i].email : "";
                        newRow =  '<tr>';
                        newRow += '<td>'+response[i].razao_social+'</td>';
                        newRow += '<td><input name="u_arr_email[]"   id="u_arr_email'+response[i].id_empresa+'"   value="'+email+'" type="email"  class="form-control inputrow"></input>';
                        newRow += '    <input name="u_arr_empresa[]" id="u_arr_empresa'+response[i].id_empresa+'"  value="'+response[i].id_empresa+'" type="hidden"></input>';
                        newRow += '</td></tr>';
                        $('#empresas tbody').append(newRow);    
                    }
                }
            }
        });
    });
}         

</script>
@endsection
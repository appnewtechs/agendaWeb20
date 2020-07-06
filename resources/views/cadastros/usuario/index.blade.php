@include('layouts.padraoMain')
{!! Form::open(['method'=>'get']) !!}
<nav class="navbar navbar-expand-lg navbar-light bg-light">    
    
    <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Usuários</span></li>                
        </ul>

        <form class="form-inline my-2 my-lg-2">
        <ul class="navbar-nav input-group input-group-sm col-md-6">
    
                <div class="input-group">

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
                </div>
        </ul>
        </form>
    </div>
</nav>
{!! Form::close() !!}


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
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->telefone }}</td>
                        <td>{{ $usuario->status=='1' ? "Inativo" : "Ativo" }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_delete_{{ $usuario->id_usuario }}" action="{{ url('usuario/delete') }}" method="post">

                            <input name="id_usuario" id="id_usuario" value="{{ $usuario->id_usuario }}" type="hidden"></input>                
                            <a class='fas fa-edit'   title="Alterar" href="#update" data-toggle="modal" data-codigo ="{{ $usuario->id_usuario }}" 
                                                                                                        data-nome   ="{{ $usuario->nome  }}"
                                                                                                        data-email  ="{{ $usuario->email }}"></a>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo ="{{ $usuario->id_usuario }}"
                                                                                                        data-nome   ="{{ $usuario->nome }}"></a>
                        </form>
                        </td>
                    </tr>
                    @endforeach

            </tbody>
        </table>
        </div>
    </div> 
</div> 



@include('layouts.footerPadrao')
<script type='text/javascript'>

    document.getElementById("qtdeRegistros").textContent="Total Itens: {{ $usuarios->count() }}";
    document.getElementById("valorTotal").textContent="";

    $('#search').focus();

    $('#insert').on('shown.bs.modal', function(e) {
        $('#insert').find("#i_descModalidade").focus();
    });

    
    $('#delete').on('shown.bs.modal', function(e) {
        var codModo  = $(e.relatedTarget).data("codmodo");
        var descModo = $(e.relatedTarget).data("descmodo");

        $('#delete').find("#description").html('Modalidade de Venda: '+codModo+' - '+descModo);
        $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_delete_"+codModo+"').submit()");
    });    
</script>

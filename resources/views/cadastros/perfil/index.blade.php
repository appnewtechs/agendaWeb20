@include('layouts.padraoMain')
{!! Form::open(['method'=>'get']) !!}
<nav class="navbar navbar-expand-lg navbar-light bg-light">    
    
    <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Perfil de Usuário</span></li>                
        </ul>

        <form class="form-inline my-2 my-lg-2">
        <ul class="navbar-nav input-group input-group-sm col-md-3">
    
            <div class="input-group">
                <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" 
                       placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                <div class="input-group-append">
                    <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                    <input type="hidden" value="{{request('field')}}"  name="field"/>
                    <input type="hidden" value="{{request('sort')}}"   name="sort"/>
                </div>
            </div>
        </ul>
        </form>
    </div>
</nav>
{!! Form::close() !!}


<div id="main" class="container-fluid pt-2 pb-2">
    <div id="list" class="row border border-dark rounded pb-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" >Código</a></th>
                    <th><a class="linktd" >Nome</a></th>
                    <th><a class="linktd" >Descrição</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($perfil as $perfis)
                    <tr>
                        <td>{{ $perfis->id_perfil }}</td>
                        <td>{{ $perfis->nome }}</td>
                        <td>{{ $perfis->descricao }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_delete_{{ $perfis->id_perfil }}" action="{{ url('perfil/delete') }}" method="post">

                            <input name="id_perfil" id="id_perfil" value="{{ $perfis->id_perfil }}" type="hidden"></input>                
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codmodo ="{{ $perfis->id_perfil }}"
                                                                                                        data-descmodo="{{ $perfis->nome }}"></a>
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

    document.getElementById("qtdeRegistros").textContent="Total Itens: {{ $perfil->count() }}";
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

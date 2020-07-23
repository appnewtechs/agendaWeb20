@include('layouts.padraoMain')
{!! Form::open(['method'=>'get']) !!}
<nav class="navbar navbar-expand-lg navbar-light bg-light">    
    
    <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Empresas do Grupo</span></li>                
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


@if(Session::has('errors'))
<script type='text/javascript'>
    $(document).ready(function(){
        var nomeModal = "{{ Session('id_modal') }}";
        $('#'+nomeModal).modal('show');
    });
</script>
@endif


<div id="main" class="container-fluid pt-2 pb-2">
    <div id="list" class="row border border-dark rounded pb-0" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd">Código</a></th>
                    <th><a class="linktd">Razão Social</a></th>
                    <th><a class="linktd">Nome Fantasia</a></th>
                    <th><a class="linktd">CNPJ</a></th>
                    <th><a class="linktd">Telefone</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->id_empresa }}</td>
                        <td>{{ $empresa->razao_social }}</td>
                        <td>{{ $empresa->nome_fantasia }}</td>
                        <td>{{ $empresa->cnpj }}</td>
                        <td>{{ $empresa->telefone_fixo }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_delete_{{ $empresa->id_empresa }}" action="{{ url('empresa/delete') }}" method="post">

                            <input name="id_empresa" id="id_empresa" value="{{ $empresa->id_empresa }}" type="hidden"></input>                
                            <a class='fas fa-edit' title="Alterar" href="#update" data-toggle="modal" 
                                                                                  data-codempresa     ="{{ $empresa->codEmpresa }}"
                                                                                  data-razaosocial    ="{{ $empresa->razaoSocial }}"
                                                                                  data-nomefantasia   ="{{ $empresa->nomeFantasia }}"
                                                                                  data-tipopessoa     ="{{ $empresa->tipoPessoa }}"
                                                                                  data-cpfcnpj        ="{{ $empresa->cpfCnpj }}"
                                                                                  data-endereco       ="{{ $empresa->enderecoEmpresa }}"
                                                                                  data-bairro         ="{{ $empresa->bairroEmpresa }}"
                                                                                  data-cepempresa     ="{{ $empresa->cepEmpresa }}"
                                                                                  data-contato        ="{{ $empresa->contatoEmpresa }}"
                                                                                  data-telefone       ="{{ $empresa->numeroTelefone }}"
                                                                                  data-codestado      ="{{ $empresa->codEstado }}"
                                                                                  data-codmunicipio   ="{{ $empresa->codMunicipio }}"
                                                                                  ></a>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $empresa->id_empresa }}"
                                                                                                        data-descricao="{{ $empresa->razao_social }}"></a>
                        </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
</div> 



@include('layouts.delete')
@include('layouts.footerPadrao')

@include('cadastros.empresas.insert')
@include('cadastros.empresas.update')



<script type='text/javascript'>

    $(document).ready(function(){
        $('#search').focus();
        document.getElementById("qtdeRegistros").textContent="Total Itens: {{ $empresas->count() }}";
        document.getElementById("valorTotal").textContent="";
    });

</script>

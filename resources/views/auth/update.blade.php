@extends('layouts.layoutPadrao')
@section('content')

<div class="container-fluid" style="margin-top: 20vh;">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border border-dark rounded">
    
                <div class="card-header">Perfil de Usuário</div>
                <div class="card-body">
                    
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-12">
                        {!! Form::label("url1", "URL WS SIPVIG", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("url1",  null, ["class"=>"form-control"]) !!}
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("user1", "Usuário WS SIPVIG", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("user1",  'usuario', ["class"=>"form-control"]) !!}
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("senha1", "Senha WS SIPVIG" , ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("senha1",  'senha', ["class"=>"form-control" ]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-6">
                        {!! Form::label("bancoServer1", "Banco de Usuários - Server", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("bancoServer1",  "HADSV2\SIPVIGDSV2", ["class"=>"form-control"]) !!}
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("databaseServer1", "Database Name", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("databaseServer1",  "PORTAL_BOLETOS", ["class"=>"form-control"]) !!}
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("dbaseUser1", "Usuário", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("dbaseUser1",  'usr_boletos', ["class"=>"form-control"]) !!}
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("dbaseSenha1", "Senha" , ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("dbaseSenha1",  'senha', ["class"=>"form-control" ]) !!}
                        </div>
                    </div>
                </div>

                </div>
                
                <div class="card-footer" style="background-color: white;">
                    <div class="col-md-12 pl-0 pr-0 mr-0">
                        <div class="col-md-12 pl-0">
                            <button type="submit" class="btn btn-primary" style="background-color:#043154">
                                Salvar Parâmetros
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('layouts.footerClear')
@endsection
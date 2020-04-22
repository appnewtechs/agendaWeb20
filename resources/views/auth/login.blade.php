@include('layouts.padraoLogin')
<div id="login" class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border border-dark rounded">
                <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="card-header">Acesso / Login</div>
                    <div class="card-body pb-4">

                        <div class="form-row col-md-12 pl-5 pr-5">
                            <div class="col-md-10 offset-md-1">
                            {!! Form::label("login","Usuário" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::text("login", null, ["class"=>"form-control", "autofocus", "onkeydown"=>"setFocus(event,'#password');" ]) !!}
                            
                            @if ($errors->has('login'))
                                <span colspan='12' style="color: red;">
                                    {{ $errors->first('login') }}
                                </span>
                            @endif
                            </div>


                            <div class="col-md-10 offset-md-1">
                            {!! Form::label("password", "Senha" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::password("password", ["class"=>"form-control", "onkeydown"=>"setFocus(event,'#login-btn');" ]) !!}

                            @if ($errors->has('password'))
                                <span colspan='12' style="color: red;">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-md-4 offset-md-8">
                        <button type="submit" class="btn btn-sm btn-secondary" id="login-btn">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


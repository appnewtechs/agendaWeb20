@include('layouts.padraoLogin')
<div class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border border-dark rounded">
                <form method="POST" action="{{ route('login') }}">
                @csrf

                    <div class="card-header">Acesso / Login</div>
                    <div class="card-body pb-5">

                        <div class="form-row col-md-12 pl-5 pr-5">
                            <div class="col-md-12">
                            {!! Form::label("login","Usuário" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::text("login", null, ["class"=>"form-control", "autofocus", "onkeydown"=>"setFocus(event,'#password');" ]) !!}
                            
                            @if ($errors->has('login'))
                                <span colspan='12' style="color: red;">
                                    {{ $errors->first('login') }}
                                </span>
                            @endif
                            </div>


                            <div class="col-md-12">
                            {!! Form::label("password", "Senha" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::password("password", ["class"=>"form-control", "onkeydown"=>"javascript:if(event.keyCode==13){ form.submit(); };" ]) !!}

                            @if ($errors->has('password'))
                                <span colspan='12' style="color: red;">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-md-12 pl-5 pr-5">
                        <button type="submit" class="btn btn-sm btn-secondary" id="login-btn">Login</button>
                        {{--
                        <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Esqueceu sua Senha?') }}</a>
                        --}}
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


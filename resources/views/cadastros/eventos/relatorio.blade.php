@extends('layouts.layoutRelatorio')
@section('content')

{!! Form::open(['method'=>'get']) !!}
<nav class="navbar navbar-expand-sm navbar-light bg-light">    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Relatório de Agendas</span></li>                
        </ul>

        <form class="form-inline my-2 my-lg-2">
        <ul class="navbar-nav input-group input-group-sm col-md-3">
            <div class="input-group">
                <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" 
                        placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                <div class="input-group-append">
                    <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </ul>
        </form>
    </div>
</nav>
{!! Form::close() !!}

<div id="main" class="container-fluid pt-2 pb-5">
    <div id="list" class="row border border-light rounded" style='background: white; width:100%;'>
        <div class="table-responsive col-md-12">
            <table class="table table-bordered mb-0" style=>
                <thead class="thead-dark">

                    <th class="relEvento" style="border-color: white;">Recurso<br>Linha Atuação</th>
                    @foreach($dates as $date)

                        @php ($weekend = Carbon\Carbon::parse($date) )
                        @if ( $weekend->isWeekend() ) 
                            <th style="color: black; border-color: white; background-color: #d1eaf1;">
                            {{Carbon\Carbon::parse($date)->isoFormat('dddd')}},<br>
                            {{Carbon\Carbon::parse($date)->isoFormat('DD/MM/Y')}}
                            </th>
                        @else 
                            <th style="border-color: white;">{{Carbon\Carbon::parse($date)->isoFormat('dddd')}},
                            <br>{{Carbon\Carbon::parse($date)->isoFormat('DD/MM/Y')}}
                            </th>
                        @endif
                    @endforeach

                </thead>

                <tbody>     

                    @foreach($usuarios as $usuario)
                    <tr>

                        <td style="color: black; background-color: #e4e4e7; border-color: white;">{{ $usuario->nome }}</td>
                        @foreach($dates as $date)

                            @foreach($feriados as $feriado)
                            @endforeach


                            @php ($weekend  = Carbon\Carbon::parse($date) )
                            @if ( $weekend->isWeekend() ) 
                                <td width="100" style="padding: 5px; border-color: white; background-color: #d1eaf1;">
                            @else 
                                <td width="100" style="padding: 5px;">
                            @endif

                            @foreach($events as $evento)
                                @if ($usuario->id_usuario==$evento->id_usuario)

                                    @if ( (Carbon\Carbon::parse($date)>=Carbon\Carbon::parse($evento->start)) && 
                                          (Carbon\Carbon::parse($date)<=Carbon\Carbon::parse($evento->end)) )
                                        <div class="relEvento border border-dark rounded" style="background-color: {{ $evento->backgroundColor }}">{{ $evento->title }}</div>
                                    @endif
                                @endif
                            @endforeach
                            </td>

                        @endforeach
    
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
</div> 


<script type='text/javascript'>


//background: var(--fc-non-business-color, rgba(215, 215, 215, 0.3));
    $('#search').focus();

</script>
@endsection

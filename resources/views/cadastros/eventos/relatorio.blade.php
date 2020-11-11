@extends('layouts.layoutRelatorio')
@section('content')

<nav class="navbar navbar-expand-sm navbar-light bg-light pt-3">    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Relatório de Agendas</span></li>                
        </ul>
    </div>
</nav>

<div id="main" class="container-fluid pt-2 pb-5">
    <div id="list" class="row border border-light rounded" style='background: white; width:100%;'>
        <div class="table-responsive col-md-12">
            <table class="table table-bordered mb-0" style=>
                <thead class="thead-dark">

                    <th class="relEvento" style="border-color: white;">Recurso<br>Linha Atuação</th>
                    @foreach($dates as $date)

                        @php ($descricao = '')
                        @php ($hollyday = false)
                        @foreach($feriados as $feriado)
                            @if (Carbon\Carbon::parse($feriado->data)==Carbon\Carbon::parse($date)) 
                                @php ($hollyday = true)
                                @php ($descricao = '*** '.$feriado->descricao.' ***')
                            @endif
                        @endforeach


                        @php ($weekend = Carbon\Carbon::parse($date) )
                        @if ( $weekend->isWeekend() || $hollyday) 
                            <th style="color: black; border-color: white; background-color: #d1eaf1;">
                            {{ $descricao }}<br>
                            {{Carbon\Carbon::parse($date)->isoFormat('dddd')}},<br>
                            {{Carbon\Carbon::parse($date)->isoFormat('DD/MM/Y')}}<br>
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
                        <td style="color: black; background-color: #e4e4e7; border-color: white;">{{ $usuario->nome }}
                        <br> {{ $usuario->atuacao }}</td>
                        @foreach($dates as $date)

                            @php ($hollyday = false )
                            @foreach($feriados as $feriado)
                                @if (Carbon\Carbon::parse($feriado->data)==Carbon\Carbon::parse($date)) 
                                    @php ($hollyday = true )
                                @endif
                            @endforeach


                            @php ($weekend  = Carbon\Carbon::parse($date) )
                            @if ( $weekend->isWeekend() || $hollyday ) 
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
@endsection

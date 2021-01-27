@extends('layouts.layoutRelatorio')
@section('content')

<nav class="navbar navbar-expand-sm navbar-light bg-light pt-3">    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto font-weight-bold pl-2">
            <li><span class="linhaMestra">Relatório de Agendas</span></li>                
        </ul>
    </div>
</nav>

<div id="main" class="container-fluid pt-2 pb-1">
    <div id="list" class="row border border-light rounded" style='background: white; width:100%;'>
        <table class="table table-bordered mb-0">
            <thead class="thead-dark rouded">

                <th class="relEvento" style="border-color: white;">Recurso<br>Linha Atuação</th>
                @foreach($dates as $date)


                    <th style="padding: 5px; border-color: white;">
                    @php ($weekend = Carbon\Carbon::parse($date->id_data) )
                    @if ( $weekend->isWeekend() || $date->descricao) 
                        {{ ($date->descricao) ? ('*** '.$date->descricao.' ***') : '' }}<br>
                        {{Carbon\Carbon::parse($date->id_data)->isoFormat('dddd')}},<br>
                        {{Carbon\Carbon::parse($date->id_data)->isoFormat('DD/MM/Y')}}<br>
                    @else 
                        {{Carbon\Carbon::parse($date->id_data)->isoFormat('dddd')}},
                        <br>{{Carbon\Carbon::parse($date->id_data)->isoFormat('DD/MM/Y')}}
                    @endif
                    </th>
                @endforeach
            </thead>

            <tbody>     
                @foreach($usuarios as $usuario)
                <tr>
                    <td style="color: black; background-color: #e4e4e7; border-color: white;">{{ $usuario->nome }}
                    <br> {{ $usuario->atuacao }}</td>
                    @foreach($dates as $date)


                        @php ($weekend  = Carbon\Carbon::parse($date->id_data) )
                        @if ( $weekend->isWeekend() || $date->descricao ) 
                            <td style="padding: 5px; border-color: white; background-color: #e4e4e7;">
                        @else 
                            <td style="padding: 5px; border-color: white; background-color: #d1eaf1;">
                        @endif

                        @foreach($events as $evento)
                            @if ($usuario->id_usuario==$evento->id_usuario)

                                @if ( (Carbon\Carbon::parse($date->id_data)>=Carbon\Carbon::parse($evento->start)) && 
                                        (Carbon\Carbon::parse($date->id_data)<=Carbon\Carbon::parse($evento->end)) )
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
@endsection

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


                @php ($usuario = '')
                @foreach($events as $evento)

                    @if($usuario<>$evento->USUARIO)
                        <tr>
                        <td style="color: black; background-color: #e4e4e7; border-color: white;">{{ $evento->NOME }}
                        <br> {{ $evento->LINHA }}</td>
                       

                        @php ($dataLoop = '')
                        @php ($filtered = $events->where('USUARIO', $evento->USUARIO))


                        @foreach($filtered as $user)
    
                            @if($dataLoop<>$user->DATACAL)
                                @php ($weekend = Carbon\Carbon::parse($user->DATACAL) )
                                @if ( $weekend->isWeekend() || $user->FERIADO ) 
                                <td style="padding: 5px; border-color: white; background-color: #e4e4e7;">
                                @else 
                                <td style="padding: 5px; border-color: white; background-color: #d1eaf1;">
                                @endif


                                @php ($dataCal = $filtered->where('DATACAL', $user->DATACAL))
                                @foreach($dataCal as $dataEvento)
                            
                                    @if($dataEvento->DESCRICAO)
                                    <div class="relEvento border border-dark rounded" style="background-color: {{ $dataEvento->COR }}">{{ $dataEvento->DESCRICAO }}</div>
                                    @endif
                            
                                @endforeach
                                </td>
                            @endif
                            @php ($dataLoop = $user->DATACAL)


                        @endforeach
                        </tr>
                    @endif
 

                    @php ($usuario = $evento->USUARIO)
                @endforeach


            </tbody>
        </table>
    </div> 
</div> 
@endsection

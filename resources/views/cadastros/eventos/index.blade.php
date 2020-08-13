@extends('layouts.layoutPadrao')
@section('content')
<script src="{{ asset('assets/fullcalendar/main.js') }}"></script>
<link  href="{{ asset('assets/fullcalendar/main.css') }}" rel="stylesheet">
<link  href="{{ asset('css/customCalendar.css') }}" rel="stylesheet">

@include('layouts.erros')
<div id="main" class="container-fluid pt-2 pb-5">
    <div class="row">

        @if(Auth::user()->id_perfil=='1')
            <div id="filtros" class="col-md-2 border border-dark rounded pb-1" style='background: white'>
            </div> 
            <div id="agenda" class="col-md-10 border border-dark rounded pt-3 pb-1" style='background: white'>
                <div id="calendar">
                </div> 
            </div> 
        @else
            <div id="agenda" class="col-md-12 border border-dark rounded pr-3 pl-3 pt-3 pb-1" style='background: white;'>
                <div id="calendar">
                </div> 
            </div> 
        @endif
    </div> 
</div> 

@include('cadastros.eventos.insert')
<script type='text/javascript'>

    $(document).ready(function(){
        $('#insert').on('shown.bs.modal', function(e) {
            $("#i_title").focus();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {

            initialView: 'dayGridMonth',
            navLinks: true,
            locales: 'pt-br',
            displayEventTime: false,
            eventDisplay: 'block',

            buttonText: {
                today: "Hoje",
                month: "mês",
                week: "semana",
                day: "dia"
            },

            customButtons: {
                addAgenda: {
                    text: 'Novo Evento',
                    click: function() {

                        if("{{Auth::user()->id_perfil}}"=='1'){
                            $('#insert').modal('show');
                        } else {
                            $('#infoone').find("#description").html("Opção indisponível para o seu perfil de usuário!");
                            $('#infoone').modal('show');
                        }
                    }
                }
            },

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'addAgenda dayGridMonth,dayGridWeek,dayGridDay',
            },

            titleFormat: { 
                year: 'numeric', 
                month: 'long',
                day : 'numeric'
            }, 


            events: {
                url: "{{ route('loadEvents') }}",
                method: 'GET',

                failure: function() {
                    alert('there was an error while fetching events!');
                },
            }
        });

        calendar.render();
    });
</script>
@endsection

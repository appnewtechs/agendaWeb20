@extends('layouts.layoutPadrao')
<link  href="{{ asset('assets/fullcalendar/main.css') }}" rel="stylesheet">
<script src="{{ asset('assets/fullcalendar/main.js') }}"></script>

@section('content')
<script>

    document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {

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
                        alert('clicked the custom button!');
                    }
                }
            },

            initialView: 'dayGridMonth',
            locales: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'addAgenda dayGridMonth,dayGridWeek,dayGridDay',
            }

        });

        calendar.render();
    });

</script>

<div id="main" class="container-fluid pt-2 pb-5">
    <div class="row">
        <div id="filtros" class="col-md-2 border border-dark rounded pb-1" style='background: white'>
        </div> 
        <div id="agenda" class="col-md-10 border border-dark rounded pt-2 pb-1" style='background: white'>
            <div id="calendar">
            </div> 
        </div> 

    </div> 
</div> 


@endsection

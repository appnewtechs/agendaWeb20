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
                <div id="calendar" style="position: relative;">
                </div> 
            </div> 
        @endif
    </div> 
</div> 


@include('cadastros.eventos.insert')
@include('cadastros.eventos.update')
@include('layouts.delete')

<script type='text/javascript'>

    $(document).ready(function(){
        $('#insert').on('shown.bs.modal', function(e) {
            $("#i_title").focus();
        });

        $('#delete').on('show.bs.modal', function(e) {
            $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_delAgenda').submit()");
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
            },

            eventClick: function(info) {
                if("{{Auth::user()->id_perfil}}"=='1'){

                    $('#id_evento').val( info.event.id );
                    $('#u_id_evento').val( info.event.id );

                    $('#u_title').val( info.event.title );
                    $('#u_status').val( info.event.extendedProps.status );
                    $('#u_empresa').val( info.event.extendedProps.empresa );
                    $('#u_id_usuario').val( info.event.extendedProps.usuario );
                    $('#u_tipo_trabalho').val( info.event.extendedProps.tipo_trabalho );
                    $('#update').modal('show');

                } else {
                    $('#infoone').find("#description").html("Opção indisponível para o seu perfil de usuário!");
                    $('#infoone').modal('show');
                }
            },
            
        });

        calendar.render();
    });
</script>
@endsection

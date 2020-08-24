@extends('layouts.layoutPadrao')
@section('content')
<script src="{{ asset('assets/fullcalendar/main.js') }}"></script>
<link  href="{{ asset('assets/fullcalendar/main.css') }}" rel="stylesheet">
<link  href="{{ asset('css/customCalendar.css') }}" rel="stylesheet">

<div id="main" class="container-fluid pt-2 pb-3">
    <div class="row">

        @if(Auth::user()->id_perfil=='1')
            <div id="filtros" class="col-md-2 border border-dark rounded pt-3 pb-1" style='background: white'>
                
                <div class="row">
                    <h4 class="fc-toolbar-title">Filtros</h4>
                </div>          

                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqTitulo').slideToggle();">por Título</a>
                                </li> 
                                <li>
                                    <a id="moreTitle" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" 
                                    onclick="$('.pesqTitulo').slideToggle(function(){
                                             $('#moreTitle').html( $('.pesqTitulo').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqTitulo pl-1 pr-1 pt-1 pb-1" style="display:none">
                            <input id="search" class="form-control" name="search" type="text" placeholder="Pesquisar..." 
                            onkeydown="javascript:if(event.keyCode==13){ callendarRender(); };" aria-label="Search"/>
                        </div>
                    </div>
                </div>


                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqStatus').slideToggle();">por Status</a>
                                </li> 
                                <li>
                                    <a id="moreStatus" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" 
                                    onclick="$('.pesqStatus').slideToggle(function(){
                                             $('#moreStatus').html( $('.pesqStatus').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqStatus pl-1 pr-1 pt-1 pb-1" style="display:none">
                            {!! Form::select('filterStatus', ['2'=>'Ambos', '1'=>'Confirmado', '0'=>'A Confirmar'], "2", 
                                ['class'=>'form-control', "id"=>"filterStatus", "onchange"=>"callendarRender();" ]) !!}
                        </div>
                    </div>
                </div>


                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqEmpresa').slideToggle();">por Empresa</a>
                                </li> 
                                <li>
                                    <a id="moreEmpresa" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" 
                                    onclick="$('.pesqEmpresa').slideToggle(function(){
                                             $('#moreEmpresa').html( $('.pesqEmpresa').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqEmpresa pl-1 pr-1 pt-1 pb-1" style="display:none">
                            @foreach ($empresasCombo as $id_empresa=>$razao_social)
                                <div class="checkbox">
                                <input name="checkEmpresas[]" value="{{ $id_empresa }}" type="checkbox" onClick="callendarRender();"></input>
                                <label class="mb-0">{{ $razao_social }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqUsuario').slideToggle();">por Usuário</a>
                                </li> 
                                <li>
                                    <a id="moreUsuario" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" 
                                    onclick="$('.pesqUsuario').slideToggle(function(){
                                             $('#moreUsuario').html( $('.pesqUsuario').is(':visible') ? '&#9650':'&#9660' ); });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqUsuario pl-1 pr-1 pt-1 pb-1" style="display:none">
                            @foreach ($usuariosCombo as $id_usuario=>$nome)
                                <div class="checkbox">
                                <input name="checkUsuarios[]" value="{{ $id_usuario }}" type="checkbox" onClick="callendarRender();"></input>
                                <label class="mb-0">{{ $nome }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>



                <div class="row pb-1">
                    <div class="col-md-12 border border-dark rounded pb-0 pr-0 pl-0" style='border-color: steelblue !important;'>
                        <nav class="navbar navbar-expand-lg navbar-dark bg-dark pr-1 pl-1" style="height: 27px; font-size: 0.7rem;">
                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav col-md-12">
                                <li class="col-md-11 pl-1">
                                    <a class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" onclick="$('.pesqTrabalho').slideToggle();">por Tipo</a>
                                </li> 
                                <li>
                                    <a id="moreTrabalho" class="fc-col-header-cell-cushion" style="font-size: 0.9rem;" href="#" 
                                    onclick="$('.pesqTrabalho').slideToggle(function(){
                                             $('#moreTrabalho').html( $('.pesqTrabalho').is(':visible') ? '&#9650':'&#9660' );
                                             });">&#9660</a>
                                </li>
                                </ul>
                            </div>
                        </nav>

                        <div class="pesqTrabalho pl-1 pr-1 pt-1 pb-1" style="display:none">
                            @foreach ($tipoAgendaCombo as $id_trabalho=>$descricao)
                                <div class="checkbox">
                                <input name="checkTrabalhos[]" value="{{ $id_trabalho }}" type="checkbox" onClick="callendarRender();"></input>
                                <label class="mb-0">{{ substr($descricao,0,21) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

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
@include('cadastros.eventos.delete')

<script type='text/javascript'>

    $(document).ready(function(){
        callendarRender();
    });


    function excluirData(element, index){
        console.log(element);
        document.getElementById(element).deleteRow(index);
    };



    function callendarRender(){
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {

            initialView: 'dayGridMonth',
            contentHeight: 'auto',
            navLinks: true,
            locales: 'pt-br',
            displayEventTime: false,
            eventDisplay: 'block',

            buttonText: {
                today: "Hoje",
                month: "Mês",
                week: "Semana",
                day:  "Dia",
                list: "Lista Mês"
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
                right: 'addAgenda dayGridMonth,dayGridWeek,dayGridDay,listMonth',
            },

            titleFormat: { 
                year: 'numeric', 
                month: 'long',
                day : 'numeric'
            }, 

            events: {
                url: "{{ route('loadEvents') }}",
                method: 'GET',
                extraParams: {
                    filterTitle:  $('#search').val(),
                    filterStatus: $('#filterStatus').val(),
                    filterUsuario: $("input[name='checkUsuarios[]']").map(
                                        function(){ 
                                            if ($(this).is(':checked')){
                                                return $(this).val(); 
                                            }
                                    }).get(),

                    filterEmpresa: $("input[name='checkEmpresas[]']").map(
                                        function(){ 
                                            if ($(this).is(':checked')){
                                                return $(this).val(); 
                                            }
                                    }).get(),

                    filterTrabalho: $("input[name='checkTrabalhos[]']").map(
                                        function(){ 
                                            if ($(this).is(':checked')){
                                                return $(this).val(); 
                                            }
                                    }).get(),
                },
            },

            eventClick: function(info) {

                if("{{Auth::user()->id_perfil}}"=='1'){

                    // Modal delete
                    $('#id_evento').val( info.event.id );
                    
                    // Modal update
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
    };

</script>
@endsection

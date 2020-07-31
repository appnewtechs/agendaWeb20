@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}">

@section('header-name','Agendas')
@section('content')

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        initialView: 'dayGridMonth'
    })
});
</script>


<div id="calendar">
</div> 
@endsection

@extends('layouts.app')

@section('content')

    <livewire:archived/>

    {{--<h2>Sound Information</h2>
    <div id="length">Duration:</div>
    <div id="source">Source:</div>
    <div id="status" style="color:red;">Status: Loading</div>
    <hr>
    <h2>Control Buttons</h2>
    <button id="play">Play</button>
    <button id="pause">Pause</button>
    <button id="restart">Restart</button>
    <hr>
    <h2>Playing Information</h2>
    <div id="currentTime">0</div>--}}

@endsection


@push('js')


@endpush

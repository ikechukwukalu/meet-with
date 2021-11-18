@extends('layouts.app')

@section('content')
<div class="container">
    @livewire('meetings')
    @livewire('program-slots')
</div>
@endsection
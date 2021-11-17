@extends('layouts.app')

@section('content')
<div class="container">
    @livewire('meetings')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header">{{ __('Slots') }}</div>

                <div class="card-body">
                    @livewire('program-slots')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Escanear Cupón')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('admin.qr-scanner')
</div>
@endsection



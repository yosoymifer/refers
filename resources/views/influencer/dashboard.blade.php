@extends('layouts.app')

@section('title', 'Mi Panel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-[#1e5128] mb-8">Mi Panel</h1>
    @livewire('influencer.dashboard')
</div>
@endsection



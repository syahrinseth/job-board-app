
@extends('layouts.app')
@section('content')
<div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
    <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-6xl lg:flex-row">
        {{-- <livewire:hello-world /> --}}
        <livewire:job-create />
        <livewire:job-list class="lg:ml-8 lg:w-1/2" />
    </main>
</div>
@endsection

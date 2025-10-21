<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst(Auth::user()->role) }} Dashboard
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->isAdmin())
                @include('dashboard.partials.admin-content')
            @elseif(Auth::user()->isEmployer())
                @include('dashboard.partials.employer-content')
            @else
                @include('dashboard.partials.guest-content')
            @endif
        </div>
    </div>
</x-app-layout>

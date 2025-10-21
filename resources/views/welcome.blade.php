
@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Hero Section -->
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    Find Your <span class="text-indigo-600">Dream Job</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Connect with top employers and discover opportunities that match your skills and career goals.
                </p>
                {{-- Job Search Component --}}
                <livewire:job-search />
            </div>
        </div>
    </div>

    <!-- Job Listings and Creation -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-1 lg:gap-8">
            <!-- Job Listings (Right side) -->
            <div>
                <livewire:job-list />
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Employer Dashboard Content -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- My Jobs Card -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">My Jobs</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ Auth::user()->jobs()->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Applications Card -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Applications Received</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ Auth::user()->jobs()->withCount('applications')->get()->sum('applications_count') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Jobs Card -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Jobs with Applications</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ Auth::user()->jobs()->has('applications')->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- This Month Card -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">This Month</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ Auth::user()->jobs()->whereMonth('created_at', now()->month)->count() }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Job Management and Applications -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Jobs -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">My Recent Jobs</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-500">View all</a>
            </div>
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse(Auth::user()->jobs()->latest()->take(5)->get() as $job)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $job->title }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                        {{ $job->company }} • {{ $job->location }}
                                    </p>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <div class="text-right">
                                        <p>{{ $job->applications->count() }} applications</p>
                                        <p class="text-xs">{{ $job->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-gray-500 dark:text-gray-400">
                            <p>No jobs posted yet</p>
                            <a href="#" class="text-blue-600 hover:text-blue-500 text-sm">Post your first job</a>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Applications</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-500">View all</a>
            </div>
            <div class="flow-root">
                <ul class="-my-5 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse(App\Models\JobApplication::with('job')->whereHas('job', function($query) { $query->where('owner_id', Auth::id()); })->latest()->take(5)->get() as $application)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ substr($application->full_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $application->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                        Applied for {{ $application->job->title }}
                                    </p>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $application->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-gray-500 dark:text-gray-400">No applications yet</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Employer Quick Actions -->
<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Post New Job</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Create a new job posting</p>
                </div>
            </a>

            <a href="#" class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Manage Jobs</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Edit and manage your job postings</p>
                </div>
            </a>

            <a href="#" class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Review Applications</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Review and manage applications</p>
                </div>
            </a>
        </div>
    </div>
</div>

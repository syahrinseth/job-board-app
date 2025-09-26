<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class JobList extends Component
{
    public $currentSearch = '';
    public $log = [];
    public $perPage = 5;

    #[On('jobCreated')]
    public function handleJobCreated($jobId)
    {
        $this->refreshJobs();
    }

    #[On('jobUpdated')]
    public function handleJobUpdated()
    {
        $this->refreshJobs();
    }

    public function viewJob($jobId)
    {
        $this->dispatch('jobViewed', $jobId);
    }

    public function editJob($jobId)
    {
        $this->dispatch('editJob', $jobId);
    }

    public function mount()
    {
        $this->refreshJobs();
    }

    public function deleteJob($jobId)
    {
        $job = Job::find($jobId);
        if ($job) {
            $job->delete();
            $this->refreshJobs();
        }
    }

    #[On('searchUpdated')]
    public function handleSearchUpdated($search)
    {
        $this->currentSearch = $search;
        $this->refreshJobs();
    }

    public function dehydrate()
    {
        $this->log[] = 'dehydrate called at ' . now()->format('H:i:s.u');
        // $this->jobs = $this->jobs?->toArray();
    }

    public function hydrate()
    {
        $this->log[] = 'hydrate called at ' . now()->format('H:i:s.u');
        // $this->jobs = collect($this->jobs)->map(fn($j) => new Job($j));
    }

    protected function refreshJobs()
    {
        if (empty($this->currentSearch)) {
            return Job::latest()->paginate($this->perPage);
        } else {
            return Job::where('title', 'like', '%' . $this->currentSearch . '%')
                ->orWhere('company', 'like', '%' . $this->currentSearch . '%')
                ->orWhere('location', 'like', '%' . $this->currentSearch . '%')
                ->latest()
                ->paginate($this->perPage);
        }
    }

    #[On('loadMore')]
    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function render()
    {
        $jobs = $this->refreshJobs();
        return view('livewire.job-list', [
            'jobs' => $jobs,
        ]);
    }
}

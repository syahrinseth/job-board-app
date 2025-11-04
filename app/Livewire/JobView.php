<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Attributes\On;
use Livewire\Component;

class JobView extends Component
{
    public $jobId;
    public $title;
    public $company;
    public $location;
    public $description;
    public $created_at;
    public bool $showModal = false;

    #[On('jobViewed')]
    public function viewJob($jobId)
    {
        $job = Job::find($jobId);
        if ($job) {
            $this->jobId = $job->id;
            $this->title = $job->title;
            $this->company = $job->company;
            $this->location = $job->location;
            $this->description = $job->description;
            $this->created_at = $job->created_at;
            $this->showModal = true;
        }
    }

    public function applyForJob($jobId)
    {
        $this->dispatch('applyForJob', $jobId);
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.job-view');
    }
}

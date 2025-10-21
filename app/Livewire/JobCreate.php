<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class JobCreate extends Component
{
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $company = '';

    #[Validate('required|string|max:255')]
    public $location = '';

    #[Validate('required|string|min:10')]
    public $description = '';

    #[Validate('required|string|max:255')]
    public $requirements = '';

    #[Validate('required|string|max:255')]
    public $salary_range = '';

    #[Validate('required|in:full-time,part-time,contract,freelance,internship')]
    public $job_type = 'full-time';

    #[Validate('required|in:remote,onsite,hybrid')]
    public $work_type = 'onsite';

    public $success_message = '';

    public function mount()
    {
        // Only employers and admins can create jobs
        if (!Auth::user()->isEmployer() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized to create jobs.');
        }
    }

    public function save()
    {
        // Only employers and admins can create jobs
        if (!Auth::user()->isEmployer() && !Auth::user()->isAdmin()) {
            session()->flash('error', 'You are not authorized to create jobs.');
            return;
        }

        $validated = $this->validate();

        $job = Job::create([
            'title' => $validated['title'],
            'company' => $validated['company'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'requirements' => $validated['requirements'],
            'salary_range' => $validated['salary_range'],
            'job_type' => $validated['job_type'],
            'work_type' => $validated['work_type'],
            'owner_id' => Auth::id(),
        ]);

        $this->success_message = 'Job posted successfully!';
        $this->dispatch('jobCreated', $job->id);

        $this->reset([
            'title', 'company', 'location', 'description',
            'requirements', 'salary_range', 'job_type', 'work_type'
        ]);

        // Redirect to job list or dashboard
        return $this->redirect('/dashboard', navigate: true);
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'company', 'location', 'description',
            'requirements', 'salary_range', 'job_type', 'work_type'
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.job-create');
    }
}

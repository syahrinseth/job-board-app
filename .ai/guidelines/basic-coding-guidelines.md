# Laravel Job Board - Coding Guidelines

## Project Overview
- **Laravel Version**: 12.27.1
- **PHP Version**: 8.3.24
- **Livewire Version**: 3.6.4
- **Database**: SQLite
- **CSS Framework**: Tailwind CSS 4.1.12
- **Testing**: PHPUnit 11.5.35

## General PHP Guidelines

### Code Style & Formatting
- **Always use Laravel Pint** for code formatting: `vendor/bin/pint --dirty`
- Use explicit return types for all methods and functions
- Use PHP 8+ constructor property promotion when possible
- Always use curly braces for control structures, even single-line statements

```php
// ✅ Good
public function __construct(public User $user) {}

public function getName(): string
{
    return $this->name;
}

if ($condition) {
    doSomething();
}

// ❌ Bad
public function __construct($user) {
    $this->user = $user;
}

public function getName() {
    return $this->name;
}

if ($condition) doSomething();
```

### Type Declarations
- Always use explicit type hints for parameters and return types
- Use nullable types (`?string`) when appropriate
- Prefer union types over mixed when possible

```php
// ✅ Good
protected function processApplication(User $user, ?string $notes = null): bool
{
    // implementation
}

// ❌ Bad
protected function processApplication($user, $notes = null)
{
    // implementation
}
```

## Laravel Guidelines

### File Creation
- Use `php artisan make:` commands for all Laravel files
- Pass `--no-interaction` flag to ensure commands work without user input
- For generic PHP classes, use `artisan make:class`

### Models & Database
- Always use Eloquent relationships with proper return types
- Prefer `Model::query()` over `DB::`
- Use eager loading to prevent N+1 queries
- Create factories and seeders for all models

```php
// ✅ Good
class Job extends Model
{
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
    
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}

// Usage with eager loading
$jobs = Job::with('applications')->active()->get();

// ❌ Bad
class Job extends Model
{
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
```

### Controllers & Validation
- Create Form Request classes for validation instead of inline validation
- Include both validation rules and custom error messages
- Use resource controllers when appropriate

```php
// ✅ Good - Create Form Request
php artisan make:request StoreJobApplicationRequest

class StoreJobApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
    
    public function messages(): array
    {
        return [
            'resume.required' => 'Please upload your resume.',
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
        ];
    }
}
```

### Configuration & Environment
- Never use `env()` function outside of config files
- Always use `config('app.name')` instead of `env('APP_NAME')`

```php
// ✅ Good
$appName = config('app.name');

// ❌ Bad
$appName = env('APP_NAME');
```

### URL Generation
- Prefer named routes and `route()` function for generating URLs
- Use `url()` helper for external URLs only

```php
// ✅ Good
<a href="{{ route('jobs.show', $job) }}">View Job</a>

// ❌ Bad
<a href="/jobs/{{ $job->id }}">View Job</a>
```

## Livewire 3 Guidelines

### Component Structure
- Use `App\Livewire` namespace (not `App\Http\Livewire`)
- Components must have a single root element
- Use `php artisan make:livewire` to create components

```php
// ✅ Good
<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

class JobApply extends Component
{
    #[Validate('required|string|max:255')]
    public $full_name = '';
    
    public function submitApplication(): void
    {
        $this->validate();
        // implementation
    }
    
    public function render()
    {
        return view('livewire.job-apply');
    }
}
```

### Properties & Validation
- Use Livewire Attributes for validation: `#[Validate('rules')]`
- Initialize public properties with default values
- Use computed properties for derived data

```php
// ✅ Good
#[Validate('required|email')]
public $email = '';

public function getJobProperty(): ?Job
{
    return $this->jobId ? Job::find($this->jobId) : null;
}

// ❌ Bad
public $email; // No default value
```

### Data Binding
- Use `wire:model.live` for real-time updates
- Use `wire:model` for deferred updates (default behavior)
- Add `wire:key` in loops for proper tracking

```blade
{{-- ✅ Good --}}
<input wire:model.live="search" type="text" placeholder="Search jobs...">

@foreach ($jobs as $job)
    <div wire:key="job-{{ $job->id }}">
        {{ $job->title }}
    </div>
@endforeach

{{-- ❌ Bad --}}
<input wire:model="search" type="text"> {{-- When you need real-time --}}

@foreach ($jobs as $job)
    <div>{{ $job->title }}</div> {{-- Missing wire:key --}}
@endforeach
```

### Events & Actions
- Use `$this->dispatch()` for events (not `emit` or `dispatchBrowserEvent`)
- Use `#[On('eventName')]` attribute for event listeners
- Use descriptive event names

```php
// ✅ Good
public function submitApplication(): void
{
    // process application
    $this->dispatch('applicationSubmitted', $this->application->id);
}

#[On('applicationSubmitted')]
public function handleApplicationSubmitted($applicationId): void
{
    // handle event
}

// ❌ Bad
public function submitApplication()
{
    $this->emit('submitted'); // Vague event name
}
```

### File Uploads
- Use `WithFileUploads` trait
- Validate file types and sizes
- Store files in appropriate directories

```php
// ✅ Good
use Livewire\WithFileUploads;

class JobApply extends Component
{
    use WithFileUploads;
    
    #[Validate('required|file|mimes:pdf,doc,docx|max:10240')]
    public $resume;
    
    public function submitApplication(): void
    {
        $this->validate();
        
        $resumePath = $this->resume->store('resumes', 'public');
        // use $resumePath
    }
}
```

### State Management
- Avoid storing complex objects in public properties
- Use IDs and computed properties for models
- Reset forms after successful operations

```php
// ✅ Good
public $jobId = null;

public function getJobProperty(): ?Job
{
    return $this->jobId ? Job::find($this->jobId) : null;
}

public function resetForm(): void
{
    $this->full_name = '';
    $this->email = '';
    // reset other fields
}

// ❌ Bad
public $job = null; // Complex object serialization issues
```

### Loading States
- Use `wire:loading` for better UX
- Use `wire:target` to specify which actions trigger loading
- Use `wire:dirty` to show unsaved changes

```blade
{{-- ✅ Good --}}
<button wire:click="submitApplication" wire:loading.attr="disabled">
    <span wire:loading.remove wire:target="submitApplication">Submit Application</span>
    <span wire:loading wire:target="submitApplication">Submitting...</span>
</button>

<div wire:dirty class="text-yellow-600">
    You have unsaved changes
</div>
```

## Tailwind CSS 4 Guidelines

### Import Statement
- Use `@import "tailwindcss"` (not `@tailwind` directives)

```css
/* ✅ Good - resources/css/app.css */
@import "tailwindcss";

/* ❌ Bad */
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Utility Classes
- Use updated utility names (v4 changes)
- Use `gap-*` for spacing instead of margins in flex/grid
- Group related classes logically

```blade
{{-- ✅ Good --}}
<div class="flex gap-4 items-center">
    <div class="shrink-0">Icon</div>
    <div class="text-ellipsis">Content</div>
</div>

{{-- ❌ Bad --}}
<div class="flex items-center">
    <div class="flex-shrink-0 mr-4">Icon</div>
    <div class="overflow-ellipsis">Content</div>
</div>
```

### Dark Mode Support
- Use `dark:` prefix for dark mode variants when needed
- Follow existing dark mode patterns in the project

```blade
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
    Content
</div>
```

## Testing Guidelines

### Test Structure
- Use PHPUnit for all tests
- Create both unit and feature tests as appropriate
- Use factories for model creation in tests

```php
// ✅ Good
class JobApplicationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_apply_for_job(): void
    {
        $job = Job::factory()->create();
        
        $response = $this->post(route('jobs.apply', $job), [
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            // other required fields
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('job_applications', [
            'job_id' => $job->id,
            'email' => 'john@example.com',
        ]);
    }
}
```

### Livewire Testing
- Test Livewire components using `Livewire::test()`
- Test both state changes and rendered output

```php
public function test_job_application_form_validation(): void
{
    $job = Job::factory()->create();
    
    Livewire::test(JobApply::class)
        ->call('applyForJob', $job->id)
        ->set('email', 'invalid-email')
        ->call('submitApplication')
        ->assertHasErrors(['email']);
}
```

### Running Tests
- Run specific tests: `php artisan test --filter=testName`
- Run all tests: `php artisan test`
- Always run tests after making changes

## Error Handling & Debugging

### Exception Handling
- Use try-catch blocks for operations that might fail
- Provide meaningful error messages to users
- Log errors for debugging

```php
// ✅ Good
public function submitApplication(): void
{
    $this->validate();
    
    try {
        // application logic
        session()->flash('message', 'Application submitted successfully!');
    } catch (Exception $e) {
        logger()->error('Job application failed', [
            'job_id' => $this->jobId,
            'email' => $this->email,
            'error' => $e->getMessage(),
        ]);
        
        session()->flash('error', 'Failed to submit application. Please try again.');
    }
}
```

### Logging
- Use appropriate log levels
- Include context in log messages
- Don't log sensitive information

```php
// ✅ Good
logger()->info('Job application submitted', [
    'job_id' => $job->id,
    'applicant_email' => $email,
]);

// ❌ Bad
logger()->info('Application submitted'); // No context
```

## Security Guidelines

### File Uploads
- Always validate file types and sizes
- Store uploaded files outside web root when possible
- Scan files for malware if handling sensitive uploads

### Input Validation
- Validate all user input
- Use Laravel's validation rules
- Sanitize output when displaying user content

### Authentication & Authorization
- Use Laravel's built-in auth features
- Implement proper authorization checks
- Use gates and policies for complex authorization logic

## Performance Guidelines

### Database Queries
- Use eager loading to prevent N+1 queries
- Use database indexes for frequently queried columns
- Consider query optimization for large datasets

### Caching
- Cache expensive operations
- Use appropriate cache tags and TTL
- Clear cache when data changes

### Asset Optimization
- Use Vite for asset bundling
- Optimize images before uploading
- Use CDN for static assets in production

## Documentation & Comments

### Code Documentation
- Write clear, descriptive method and class names
- Use PHPDoc blocks for complex methods
- Avoid obvious comments

```php
// ✅ Good
/**
 * Calculate the application deadline based on job posting date
 * and company-specific buffer period.
 */
public function calculateApplicationDeadline(Job $job): Carbon
{
    return $job->posted_at->addDays($job->company->application_buffer_days);
}

// ❌ Bad
// This method returns the name
public function getName()
{
    return $this->name; // Returns the name
}
```

### Commit Messages
- Use conventional commit format
- Write clear, descriptive messages
- Reference issues when applicable

```
feat: add job application form with file upload
fix: resolve job_id null constraint violation in JobApply component
docs: update coding guidelines for Livewire 3
```

## Deployment & CI/CD

### Pre-deployment Checklist
- Run `vendor/bin/pint --dirty` to format code
- Run `php artisan test` to ensure all tests pass
- Check for any remaining TODOs or debug code
- Verify environment variables are set correctly

### Environment Configuration
- Use different configurations for different environments
- Never commit sensitive data to version control
- Use proper queue drivers in production

This document should be updated as the project evolves and new patterns emerge.

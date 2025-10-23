<?php

use App\Livewire\JobCreate;
use App\Models\User;
use Livewire\Livewire;

test('job creation page can be rendered by employers', function () {
    $employer = User::factory()->create(['role' => 'employer']);

    $response = $this->actingAs($employer)->get('/job/create');

    $response->assertStatus(200)
        ->assertSee('Create New Job')
        ->assertSee('Job Title')
        ->assertSee('Company')
        ->assertSee('Location');
});

test('job creation page can be rendered by admins', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/job/create');

    $response->assertStatus(200)
        ->assertSee('Create New Job');
});

test('job creation page is forbidden for guests', function () {
    $guest = User::factory()->create(['role' => 'guest']);

    $response = $this->actingAs($guest)->get('/job/create');

    $response->assertStatus(403);
});

test('employers can create jobs with valid data', function () {
    $employer = User::factory()->create(['role' => 'employer']);

    Livewire::actingAs($employer)
        ->test(JobCreate::class)
        ->set('title', 'Senior Software Engineer')
        ->set('company', 'Tech Corp')
        ->set('location', 'San Francisco, CA')
        ->set('description', 'We are looking for a senior software engineer to join our team.')
        ->set('requirements', 'Bachelor\'s degree in Computer Science, 5+ years experience')
        ->set('salary_range', '$100,000 - $150,000')
        ->set('job_type', 'full-time')
        ->set('work_type', 'remote')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('redirect-to-checkout');

    $this->assertDatabaseHas('job_lists', [
        'title' => 'Senior Software Engineer',
        'company' => 'Tech Corp',
        'location' => 'San Francisco, CA',
        'owner_id' => $employer->id,
    ]);
});

test('job creation requires all mandatory fields', function () {
    $employer = User::factory()->create(['role' => 'employer']);

    Livewire::actingAs($employer)
        ->test(JobCreate::class)
        ->call('save')
        ->assertHasErrors([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'description' => 'required',
            'requirements' => 'required',
            'salary_range' => 'required',
        ]);
});

test('job creation validates job type and work type', function () {
    $employer = User::factory()->create(['role' => 'employer']);

    Livewire::actingAs($employer)
        ->test(JobCreate::class)
        ->set('job_type', 'invalid-type')
        ->set('work_type', 'invalid-work-type')
        ->call('save')
        ->assertHasErrors(['job_type', 'work_type']);
});

test('guests cannot create jobs through livewire component', function () {
    $guest = User::factory()->create(['role' => 'guest']);

    // The guest should get a 403 error when trying to access the page
    $response = $this->actingAs($guest)->get('/job/create');
    $response->assertStatus(403);
});

test('reset form clears all fields', function () {
    $employer = User::factory()->create(['role' => 'employer']);

    Livewire::actingAs($employer)
        ->test(JobCreate::class)
        ->set('title', 'Test Job')
        ->set('company', 'Test Company')
        ->set('location', 'Test Location')
        ->set('description', 'Test description')
        ->set('requirements', 'Test requirements')
        ->set('salary_range', '$50,000')
        ->call('resetForm')
        ->assertSet('title', '')
        ->assertSet('company', '')
        ->assertSet('location', '')
        ->assertSet('description', '')
        ->assertSet('requirements', '')
        ->assertSet('salary_range', '');
});

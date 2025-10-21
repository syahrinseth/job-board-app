<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Show the job creation form.
     */
    public function create(): View
    {
        // Authorization check - only employers and admins can create jobs
        if (! Auth::check() || ! in_array(Auth::user()->role, ['employer', 'admin'])) {
            abort(403, 'Unauthorized. Only employers and admins can create jobs.');
        }

        return view('jobs.create');
    }
}

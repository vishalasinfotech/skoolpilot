<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Feedback\StoreFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(): View
    {
        return view('school-admin.feedback.index');
    }

    public function create(): View
    {
        return view('school-admin.feedback.create');
    }

    public function store(StoreFeedbackRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['school_id'] = auth()->user()->school_id;

        $data['status'] = 'pending';
        Feedback::create($data);

        return redirect()->route('school-admin.feedback.index')
            ->with('success', 'Feedback submitted successfully.');
    }
}

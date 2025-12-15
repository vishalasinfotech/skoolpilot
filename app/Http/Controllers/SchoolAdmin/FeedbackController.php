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
        $user = auth()->user();

        Feedback::create([
            'created_by' => $user->id,
            'school_id' => $user->school_id,
            'subject' => $request->validated()['subject'],
            'message' => $request->validated()['message'],
            'type' => $request->validated()['type'] ?? 'general',
            'status' => 'pending',
        ]);

        return redirect()->route('school-admin.feedback.index')
            ->with('success', 'Feedback submitted successfully.');
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Feedback\UpdateFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware(static function ($request, $next) {
            Gate::authorize('access-super-admin');

            return $next($request);
        });
    }

    public function index(): View
    {
        return view('super-admin.feedback.index');
    }

    public function show(Feedback $feedback): View
    {
        $feedback->load(['createdBy', 'school']);

        return view('super-admin.feedback.show', compact('feedback'));
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['admin_response'])) {
            $data['responded_at'] = now();
        }

        $feedback->update($data);

        return redirect()->route('super-admin.feedback.index')
            ->with('success', 'Feedback updated successfully.');
    }
}

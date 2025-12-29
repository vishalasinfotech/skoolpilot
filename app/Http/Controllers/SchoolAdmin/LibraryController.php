<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Library\IssueBookRequest;
use App\Http\Requests\SchoolAdmin\Library\ReturnBookRequest;
use App\Http\Requests\SchoolAdmin\Library\StoreLibraryRequest;
use App\Http\Requests\SchoolAdmin\Library\UpdateLibraryRequest;
use App\Models\BookIssue;
use App\Models\Library;
use App\Models\School;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Library::class);

        return view('school-admin.library.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Library::class);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.library.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibraryRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $this->authorize('create', Library::class);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['school_id'] = auth()->user()->school_id;
        if ($request->hasFile('book_image')) {
            $data['book_image'] = $imageUploadService->uploadImage(
                $request->file('book_image'),
                'uploads/library/books'
            );
        }

        Library::create($data);

        return redirect()->route('school-admin.library.index')
            ->with('success', 'Book added to library successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Library $library): View
    {
        $this->authorize('view', $library);
        $library->load('school');

        return view('school-admin.library.show', compact('library'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Library $library): View
    {
        $this->authorize('update', $library);
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.library.edit', compact('library', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibraryRequest $request, Library $library, ImageUploadService $imageUploadService): RedirectResponse
    {
        $this->authorize('update', $library);
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('book_image')) {
            $data['book_image'] = $imageUploadService->uploadImage(
                $request->file('book_image'),
                'uploads/library/books',
                $library->book_image
            );
        }

        $library->update($data);

        return redirect()->route('school-admin.library.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Library $library): RedirectResponse
    {
        $this->authorize('delete', $library);
        if ($library->book_image && file_exists(public_path($library->book_image))) {
            unlink(public_path($library->book_image));
        }

        $library->delete();

        return redirect()->route('school-admin.library.index')
            ->with('success', 'Book deleted successfully.');
    }

    /**
     * Show the form for issuing a book.
     */
    public function issue(): View
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');
        $books = Library::where('deleted_at', null)
            ->where('is_active', true)
            ->where('available_copies', '>', 0)
            ->with('school')
            ->get()
            ->mapWithKeys(function ($book) {
                return [$book->id => "{$book->book_title} - {$book->author} (Available: {$book->available_copies})"];
            });
        $users = User::where('deleted_at', null)
            ->where('is_active', true)
            ->whereIn('role', ['student', 'staff', 'teacher'])
            ->get()
            ->mapWithKeys(function ($user) {
                $role = ucfirst($user->role);
                $identifier = $user->admission_number ?? $user->employee_id ?? $user->email;

                return [$user->id => "{$user->full_name} ({$role} - {$identifier})"];
            });

        return view('school-admin.library.issue', compact('schools', 'books', 'users'));
    }

    /**
     * Store a newly issued book.
     */
    public function issueBook(IssueBookRequest $request): RedirectResponse
    {
        $this->authorize('create', BookIssue::class);
        $data = $request->validated();
        $library = Library::findOrFail($data['library_id']);

        // Check if book is available
        if ($library->available_copies <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This book is not available. All copies are currently issued.');
        }

        // Get school_id from library
        $data['school_id'] = $library->school_id;

        // Determine status based on due date
        $data['status'] = strtotime($data['due_date']) < strtotime('today') ? 'overdue' : 'issued';

        // Create book issue
        BookIssue::create($data);

        // Decrease available copies
        $library->decrement('available_copies');

        return redirect()->route('school-admin.library.issued-books')
            ->with('success', 'Book issued successfully.');
    }

    /**
     * Display a listing of issued books.
     */
    public function issuedBooks(): View
    {
        return view('school-admin.library.issued-books');
    }

    /**
     * Return an issued book.
     */
    public function returnBook(ReturnBookRequest $request, BookIssue $bookIssue): RedirectResponse
    {
        $this->authorize('update', $bookIssue);
        if ($bookIssue->status === 'returned') {
            return redirect()->back()
                ->with('error', 'This book has already been returned.');
        }

        $data = $request->validated();
        $data['status'] = 'returned';

        $bookIssue->update($data);

        // Increase available copies
        $library = $bookIssue->library;
        $library->increment('available_copies');

        return redirect()->route('school-admin.library.issued-books')
            ->with('success', 'Book returned successfully.');
    }
}

<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Library\StoreLibraryRequest;
use App\Http\Requests\SchoolAdmin\Library\UpdateLibraryRequest;
use App\Models\Library;
use App\Models\School;
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
        return view('school-admin.library.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.library.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibraryRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('book_image')) {
            $data['book_image'] = $imageUploadService->uploadImage(
                $request->file('book_image'),
                'library/books'
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
        $library->load('school');

        return view('school-admin.library.show', compact('library'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Library $library): View
    {
        $schools = School::where('deleted_at', null)->where('status', true)->pluck('name', 'id');

        return view('school-admin.library.edit', compact('library', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibraryRequest $request, Library $library, ImageUploadService $imageUploadService): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('book_image')) {
            $data['book_image'] = $imageUploadService->uploadImage(
                $request->file('book_image'),
                'library/books',
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
        if ($library->book_image && file_exists(public_path($library->book_image))) {
            unlink(public_path($library->book_image));
        }

        $library->delete();

        return redirect()->route('school-admin.library.index')
            ->with('success', 'Book deleted successfully.');
    }
}

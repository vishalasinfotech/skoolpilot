<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperAdmin\Language\StoreLanguageRequest;
use App\Http\Requests\SuperAdmin\Language\UpdateLanguageRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch application language.
     */
    public function switch(Request $request): RedirectResponse
    {
        $locale = $request->input('locale', Language::getDefaultCode());

        // Validate locale against database
        $language = Language::where('code', $locale)
            ->where('is_active', true)
            ->first();

        if (! $language) {
            // Fallback to default language
            $locale = Language::getDefaultCode();
        }

        // Set locale in session
        Session::put('locale', $locale);

        // Set locale for current request
        App::setLocale($locale);

        return redirect()->back();
    }

    /**
     * Display a listing of languages.
     */
    public function index()
    {
        return view('super-admin.language.index');
    }

    /**
     * Show the form for creating a new language.
     */
    public function create()
    {
        return view('super-admin.language.create');
    }

    /**
     * Store a newly created language in storage.
     */
    public function store(StoreLanguageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // If setting as default, unset other defaults
        if ($request->boolean('is_default')) {
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        // Prepare data with proper defaults
        $data['code'] = strtolower($data['code']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_default'] = $request->boolean('is_default', false);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Create the language
        Language::create($data);

        return redirect()->route('super-admin.language.index')
            ->with('success', __('common.language_created_successfully'));
    }

    /**
     * Show the form for editing the specified language.
     */
    public function edit(Language $language)
    {
        return view('super-admin.language.edit', compact('language'));
    }

    /**
     * Update the specified language in storage.
     */
    public function update(UpdateLanguageRequest $request, Language $language): RedirectResponse
    {
        // Cannot deactivate default language
        if ($language->is_default && ! $request->boolean('is_active')) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('common.cannot_deactivate_default_language'));
        }

        $data = $request->validated();

        // If setting as default, unset other defaults (excluding current language)
        if ($request->boolean('is_default')) {
            Language::where('is_default', true)
                ->where('id', '!=', $language->id)
                ->update(['is_default' => false]);
        }

        // Prepare data with proper defaults
        $data['code'] = strtolower($data['code']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['is_default'] = $request->boolean('is_default', false);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Update the language
        $language->update($data);

        return redirect()->route('super-admin.language.index')
            ->with('success', __('common.language_updated_successfully'));
    }

    /**
     * Remove the specified language from storage.
     */
    public function destroy(Language $language): RedirectResponse
    {
        // Cannot delete default language
        if ($language->is_default) {
            return redirect()->route('super-admin.language.index')
                ->with('error', __('common.cannot_delete_default_language'));
        }

        // Delete the language (soft delete)
        $language->delete();

        return redirect()->route('super-admin.language.index')
            ->with('success', __('common.language_deleted_successfully'));
    }

    /**
     * Toggle the active status of the specified language.
     */
    public function toggleStatus(Language $language): RedirectResponse
    {
        // Cannot deactivate default language
        if ($language->is_default) {
            return redirect()->route('super-admin.language.index')
                ->with('error', __('common.cannot_deactivate_default_language'));
        }

        $language->toggleStatus();

        return redirect()->route('super-admin.language.index')
            ->with('success', __('common.language_status_updated'));
    }

    /**
     * Set the specified language as default.
     */
    public function setAsDefault(Language $language): RedirectResponse
    {
        // Cannot set inactive language as default
        if (! $language->is_active) {
            return redirect()->route('super-admin.language.index')
                ->with('error', __('common.cannot_set_inactive_as_default'));
        }

        $language->setAsDefault();

        return redirect()->route('super-admin.language.index')
            ->with('success', __('common.default_language_updated'));
    }
}

<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Setting\UpdateSettingRequest;
use App\Models\Setting;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display white-label customization settings.
     */
    public function index(): View
    {
        $schoolId = auth()->user()->school_id;

        // Default values
        $defaults = [
            'school_logo' => Setting::get('school_logo', null, $schoolId),
            'school_favicon' => Setting::get('school_favicon', null, $schoolId),
            'primary_color' => Setting::get('primary_color', '#6366f1', $schoolId),
            'secondary_color' => Setting::get('secondary_color', '#8b5cf6', $schoolId),
            'school_name' => Setting::get('school_name', null, $schoolId),
            'school_tagline' => Setting::get('school_tagline', null, $schoolId),
            'footer_text' => Setting::get('footer_text', null, $schoolId),
            // Email settings from .env
            'mail_mailer' => Setting::get('mail_mailer', 'smtp', $schoolId),
            'mail_host' => Setting::get('mail_host', '', $schoolId),
            'mail_port' => Setting::get('mail_port', '587', $schoolId),
            'mail_username' => Setting::get('mail_username', '', $schoolId),
            'mail_password' => Setting::get('mail_password', '', $schoolId),
            'mail_encryption' => Setting::get('mail_encryption', 'tls', $schoolId),
            'mail_from_name' => Setting::get('mail_from_name', '', $schoolId),
            'mail_from_address' => Setting::get('mail_from_address', '', $schoolId),
            'support_email' => Setting::get('support_email', null, $schoolId),
            'support_phone' => Setting::get('support_phone', null, $schoolId),
            'address' => Setting::get('address', null, $schoolId),
            'website_url' => Setting::get('website_url', null, $schoolId),
            'facebook_url' => Setting::get('facebook_url', null, $schoolId),
            'twitter_url' => Setting::get('twitter_url', null, $schoolId),
            'instagram_url' => Setting::get('instagram_url', null, $schoolId),
            'linkedin_url' => Setting::get('linkedin_url', null, $schoolId),
        ];

        return view('school-admin.setting.index', compact('defaults'));
    }

    /**
     * Update white-label customization settings.
     */
    public function update(UpdateSettingRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $schoolId = auth()->user()->school_id;
        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('school_logo')) {
            $logoPath = $imageUploadService->uploadImage(
                $request->file('school_logo'),
                'settings/logo',
                Setting::get('school_logo', null, $schoolId)
            );
            Setting::set('school_logo', $logoPath, $schoolId, 'file', 'branding');
        }

        // Handle favicon upload
        if ($request->hasFile('school_favicon')) {
            $faviconPath = $imageUploadService->uploadImage(
                $request->file('school_favicon'),
                'settings/favicon',
                Setting::get('school_favicon', null, $schoolId)
            );
            Setting::set('school_favicon', $faviconPath, $schoolId, 'file', 'branding');
        }

        $emailSettings = [
            'mail_mailer' => $data['mail_mailer'] ?? null,
            'mail_host' => $data['mail_host'] ?? null,
            'mail_port' => $data['mail_port'] ?? null,
            'mail_username' => $data['mail_username'] ?? null,
            'mail_encryption' => $data['mail_encryption'] ?? null,
            'mail_from_name' => $data['mail_from_name'] ?? null,
            'mail_from_address' => $data['mail_from_address'] ?? null,
        ];

        foreach ($emailSettings as $key => $value) {
            Setting::set($key, $value, $schoolId, 'string', 'email');
        }

        $settingsToSave = [
            'primary_color' => ['type' => 'color', 'group' => 'branding'],
            'secondary_color' => ['type' => 'color', 'group' => 'branding'],
            'school_name' => ['type' => 'string', 'group' => 'branding'],
            'school_tagline' => ['type' => 'string', 'group' => 'branding'],
            'footer_text' => ['type' => 'string', 'group' => 'branding'],
            'support_email' => ['type' => 'string', 'group' => 'contact'],
            'support_phone' => ['type' => 'string', 'group' => 'contact'],
            'address' => ['type' => 'string', 'group' => 'contact'],
            'website_url' => ['type' => 'string', 'group' => 'social'],
            'facebook_url' => ['type' => 'string', 'group' => 'social'],
            'twitter_url' => ['type' => 'string', 'group' => 'social'],
            'instagram_url' => ['type' => 'string', 'group' => 'social'],
            'linkedin_url' => ['type' => 'string', 'group' => 'social'],
        ];

        foreach ($settingsToSave as $key => $config) {
            if (isset($data[$key])) {
                Setting::set($key, $data[$key], $schoolId, $config['type'], $config['group']);
            }
        }

        return redirect()->route('school-admin.setting.index')
            ->with('success', 'White-label settings updated successfully.');
    }
}

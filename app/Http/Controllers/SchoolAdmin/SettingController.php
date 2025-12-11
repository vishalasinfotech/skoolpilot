<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolAdmin\Setting\UpdateSettingRequest;
use App\Models\Setting;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Jackiedo\DotenvEditor\DotenvEditor;

class SettingController extends Controller
{
    /**
     * Display white-label customization settings.
     */
    public function index(DotenvEditor $dotenvEditor): View
    {
        $schoolId = auth()->user()->school_id;

        // Load email settings from .env
        $dotenvEditor->load();

        // Helper function to get env value
        $getEnvValue = function ($key, $default = '') use ($dotenvEditor) {
            try {
                $value = $dotenvEditor->getValue($key);

                return $value !== null ? $value : env($key, $default);
            } catch (\Exception $e) {
                return env($key, $default);
            }
        };

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
            'mail_mailer' => $getEnvValue('MAIL_MAILER', 'smtp'),
            'mail_host' => $getEnvValue('MAIL_HOST', ''),
            'mail_port' => $getEnvValue('MAIL_PORT', '587'),
            'mail_username' => $getEnvValue('MAIL_USERNAME', ''),
            'mail_password' => $getEnvValue('MAIL_PASSWORD', ''),
            'mail_encryption' => $getEnvValue('MAIL_ENCRYPTION', 'tls'),
            'mail_from_name' => $getEnvValue('MAIL_FROM_NAME', ''),
            'mail_from_address' => $getEnvValue('MAIL_FROM_ADDRESS', ''),
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
    public function update(UpdateSettingRequest $request, ImageUploadService $imageUploadService, DotenvEditor $dotenvEditor): RedirectResponse
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

        // Save email settings to .env file
        $dotenvEditor->load();

        // Email settings to save to .env
        $emailSettings = [
            'MAIL_MAILER' => $data['mail_mailer'] ?? null,
            'MAIL_HOST' => $data['mail_host'] ?? null,
            'MAIL_PORT' => $data['mail_port'] ?? null,
            'MAIL_USERNAME' => $data['mail_username'] ?? null,
            'MAIL_ENCRYPTION' => $data['mail_encryption'] ?? null,
            'MAIL_FROM_NAME' => $data['mail_from_name'] ?? null,
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'] ?? null,
        ];

        // Only update password if provided (don't overwrite with empty)
        if (! empty($data['mail_password'])) {
            $emailSettings['MAIL_PASSWORD'] = $data['mail_password'];
        }

        foreach ($emailSettings as $key => $value) {
            if ($value !== null && $value !== '') {
                $dotenvEditor->setKey($key, $value);
            }
        }

        $dotenvEditor->save();

        // Clear config cache to reload .env values
        \Artisan::call('config:clear');

        // Save other settings to database
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

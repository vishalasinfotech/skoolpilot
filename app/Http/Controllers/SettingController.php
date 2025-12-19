<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\UpdateGeneralSettingRequest;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Models\School;
use App\Models\Setting;
use App\Models\Transaction;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Jackiedo\DotenvEditor\DotenvEditor;

class SettingController extends Controller
{
    protected DotenvEditor $dotenvEditor;

    public function __construct(DotenvEditor $dotenvEditor)
    {
        $this->dotenvEditor = $dotenvEditor;
    }

    /**
     * Display white-label customization settings.
     */
    public function index(): View
    {
        Gate::authorize('access-school-admin');

        $schoolId = auth()->user()->school_id;

        // Get school subscription plan information
        $school = School::with('subscriptionPlan')->find($schoolId);

        // Get latest completed transaction for subscription details
        $latestTransaction = Transaction::query()
            ->with('subscriptionPlan')
            ->where('school_id', $schoolId)
            ->where('status', 'completed')
            ->orderByDesc('paid_at')
            ->orderByDesc('id')
            ->first();

        $subscriptionPlan = $latestTransaction?->subscriptionPlan ?? $school?->subscriptionPlan;
        $subscriptionExpiresAt = $latestTransaction?->expires_at;
        $subscriptionStatus = 'none';

        if ($latestTransaction) {
            $subscriptionStatus = ($subscriptionExpiresAt !== null && $subscriptionExpiresAt->isPast())
                ? 'expired'
                : 'active';
        }

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
            'subscription_auto_renewal' => filter_var(Setting::get('subscription_auto_renewal', false, $schoolId), FILTER_VALIDATE_BOOLEAN),
            'auto_generate_employee_id' => filter_var(Setting::get('auto_generate_employee_id', false, $schoolId), FILTER_VALIDATE_BOOLEAN),
        ];

        return view('setting.index', compact('defaults', 'subscriptionPlan', 'subscriptionExpiresAt', 'subscriptionStatus'));
    }

    /**
     * Update white-label customization settings.
     */
    public function update(UpdateSettingRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        Gate::authorize('access-school-admin');

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
            'subscription_auto_renewal' => ['type' => 'boolean', 'group' => 'subscription'],
            'auto_generate_employee_id' => ['type' => 'boolean', 'group' => 'employee'],
        ];

        foreach ($settingsToSave as $key => $config) {
            if ($config['type'] === 'boolean') {
                // For boolean checkboxes, check if the key exists in the request
                $value = isset($data[$key]) && $data[$key] == '1';
                Setting::set($key, $value, $schoolId, $config['type'], $config['group']);
            } elseif (isset($data[$key])) {
                Setting::set($key, $data[$key], $schoolId, $config['type'], $config['group']);
            }
        }

        return redirect()->route('school-admin.setting.index')
            ->with('success', 'White-label settings updated successfully.');
    }

    /**
     * Show general settings
     */
    public function general(): View
    {
        Gate::authorize('access-super-admin');

        // Get all general settings (global settings, not school-specific)
        $settings = [
            // Business Settings
            'business_name' => Setting::get('business_name', '', null),
            'business_email' => Setting::get('business_email', '', null),
            'business_phone' => Setting::get('business_phone', '', null),
            'business_address' => Setting::get('business_address', '', null),
            'business_website' => Setting::get('business_website', '', null),
            'business_registration_number' => Setting::get('business_registration_number', '', null),
            'business_tax_id' => Setting::get('business_tax_id', '', null),

            // Project Settings
            'project_name' => Setting::get('project_name', config('app.name'), null),
            'project_description' => Setting::get('project_description', '', null),
            'project_version' => Setting::get('project_version', '1.0.0', null),
            'timezone' => Setting::get('timezone', config('app.timezone'), null),
            'date_format' => Setting::get('date_format', 'Y-m-d', null),
            'time_format' => Setting::get('time_format', 'H:i', null),
            'currency' => Setting::get('currency', 'INR', null),
            'currency_symbol' => Setting::get('currency_symbol', '₹', null),

            // Contact Information
            'contact_email' => Setting::get('contact_email', '', null),
            'contact_phone' => Setting::get('contact_phone', '', null),
            'contact_mobile' => Setting::get('contact_mobile', '', null),
            'contact_address' => Setting::get('contact_address', '', null),
            'contact_city' => Setting::get('contact_city', '', null),
            'contact_state' => Setting::get('contact_state', '', null),
            'contact_country' => Setting::get('contact_country', '', null),
            'contact_postal_code' => Setting::get('contact_postal_code', '', null),

            // Social Media Links
            'facebook_url' => Setting::get('facebook_url', '', null),
            'twitter_url' => Setting::get('twitter_url', '', null),
            'instagram_url' => Setting::get('instagram_url', '', null),
            'linkedin_url' => Setting::get('linkedin_url', '', null),
            'youtube_url' => Setting::get('youtube_url', '', null),
            'whatsapp_number' => Setting::get('whatsapp_number', '', null),

            // Branding & Logo
            'logo' => Setting::get('logo', '', null),
            'favicon' => Setting::get('favicon', '', null),
            'primary_color' => Setting::get('primary_color', '#6366f1', null),
            'secondary_color' => Setting::get('secondary_color', '#8b5cf6', null),
            'footer_text' => Setting::get('footer_text', '', null),
        ];

        return view('setting.general', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(UpdateGeneralSettingRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        Gate::authorize('access-super-admin');

        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $imageUploadService->uploadImage(
                $request->file('logo'),
                'settings/logo',
                Setting::get('logo', null, null)
            );
            Setting::set('logo', $logoPath, null, 'file', 'branding');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $imageUploadService->uploadImage(
                $request->file('favicon'),
                'settings/favicon',
                Setting::get('favicon', null, null)
            );
            Setting::set('favicon', $faviconPath, null, 'file', 'branding');
        }

        // Business Settings
        $businessSettings = [
            'business_name' => 'business',
            'business_email' => 'business',
            'business_phone' => 'business',
            'business_address' => 'business',
            'business_website' => 'business',
            'business_registration_number' => 'business',
            'business_tax_id' => 'business',
        ];

        foreach ($businessSettings as $key => $group) {
            if (isset($data[$key])) {
                Setting::set($key, $data[$key], null, 'string', $group);
            }
        }

        // Project Settings
        $projectSettings = [
            'project_name' => 'project',
            'project_description' => 'project',
            'project_version' => 'project',
            'timezone' => 'project',
            'date_format' => 'project',
            'time_format' => 'project',
            'currency' => 'project',
            'currency_symbol' => 'project',
        ];

        foreach ($projectSettings as $key => $group) {
            if (isset($data[$key])) {
                Setting::set($key, $data[$key], null, 'string', $group);
            }
        }

        // Contact Information
        $contactSettings = [
            'contact_email' => 'contact',
            'contact_phone' => 'contact',
            'contact_mobile' => 'contact',
            'contact_address' => 'contact',
            'contact_city' => 'contact',
            'contact_state' => 'contact',
            'contact_country' => 'contact',
            'contact_postal_code' => 'contact',
        ];

        foreach ($contactSettings as $key => $group) {
            if (isset($data[$key])) {
                Setting::set($key, $data[$key], null, 'string', $group);
            }
        }

        // Social Media Links
        $socialSettings = [
            'facebook_url' => 'social',
            'twitter_url' => 'social',
            'instagram_url' => 'social',
            'linkedin_url' => 'social',
            'youtube_url' => 'social',
            'whatsapp_number' => 'social',
        ];

        foreach ($socialSettings as $key => $group) {
            if (isset($data[$key])) {
                Setting::set($key, $data[$key], null, 'string', $group);
            }
        }

        // Branding & Logo
        $brandingSettings = [
            'primary_color' => ['type' => 'color', 'group' => 'branding'],
            'secondary_color' => ['type' => 'color', 'group' => 'branding'],
            'footer_text' => ['type' => 'string', 'group' => 'branding'],
        ];

        foreach ($brandingSettings as $key => $config) {
            if (isset($data[$key])) {
                Setting::set($key, $data[$key], null, $config['type'], $config['group']);
            }
        }

        return redirect()->route('super-admin.setting.general')
            ->with('success', 'General settings updated successfully.');
    }

    /**
     * Show payment gateway settings
     */
    public function payment(): View
    {
        Gate::authorize('access-super-admin');

        $env = $this->dotenvEditor->load();

        $paymentSettings = [
            'RAZORPAY_KEY_ID' => $env->getValue('RAZORPAY_KEY_ID') ?? '',
            'RAZORPAY_KEY_SECRET' => $env->getValue('RAZORPAY_KEY_SECRET') ?? '',
        ];

        return view('setting.payment', compact('paymentSettings'));
    }

    /**
     * Update payment gateway settings
     */
    public function updatePayment(Request $request): RedirectResponse
    {
        Gate::authorize('access-super-admin');

        $request->validate([
            'RAZORPAY_KEY_ID' => ['required', 'string', 'max:255'],
            'RAZORPAY_KEY_SECRET' => ['required', 'string', 'max:255'],
        ]);

        $env = $this->dotenvEditor->load();

        $paymentSettings = [
            'RAZORPAY_KEY_ID' => $request->RAZORPAY_KEY_ID,
            'RAZORPAY_KEY_SECRET' => $request->RAZORPAY_KEY_SECRET,
        ];

        foreach ($paymentSettings as $key => $value) {
            $env->setKey($key, $value);
        }

        $env->save();

        return redirect()->route('super-admin.setting.payment')
            ->with('success', 'Payment gateway configuration updated successfully.');
    }
}

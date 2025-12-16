@extends('layouts.master')
@section('title', 'General Settings')
@section('main-container')
@include('layouts.badge')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">General Settings</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">General Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.badge')

        <form action="{{ route('super-admin.setting.update-general') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-12">
                    <!-- Business Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-building-line me-2"></i>Business Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="business_name" class="form-label">Business Name</label>
                                    <input type="text" name="business_name" id="business_name" class="form-control" value="{{ $settings['business_name'] }}" placeholder="Enter business name">
                                    @error('business_name')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="business_email" class="form-label">Business Email</label>
                                    <input type="email" name="business_email" id="business_email" class="form-control" value="{{ $settings['business_email'] }}" placeholder="business@example.com">
                                    @error('business_email')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="business_phone" class="form-label">Business Phone</label>
                                    <input type="text" name="business_phone" id="business_phone" class="form-control" value="{{ $settings['business_phone'] }}" placeholder="+91 1234567890">
                                    @error('business_phone')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="business_website" class="form-label">Business Website</label>
                                    <input type="url" name="business_website" id="business_website" class="form-control" value="{{ $settings['business_website'] }}" placeholder="https://example.com">
                                    @error('business_website')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="business_address" class="form-label">Business Address</label>
                                    <textarea name="business_address" id="business_address" class="form-control" rows="3" placeholder="Enter full business address">{{ $settings['business_address'] }}</textarea>
                                    @error('business_address')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="business_registration_number" class="form-label">Registration Number</label>
                                    <input type="text" name="business_registration_number" id="business_registration_number" class="form-control" value="{{ $settings['business_registration_number'] }}" placeholder="Enter registration number">
                                    @error('business_registration_number')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="business_tax_id" class="form-label">Tax ID / GST Number</label>
                                    <input type="text" name="business_tax_id" id="business_tax_id" class="form-control" value="{{ $settings['business_tax_id'] }}" placeholder="Enter tax ID">
                                    @error('business_tax_id')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Project Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-settings-3-line me-2"></i>Project Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="project_name" class="form-label">Project Name</label>
                                    <input type="text" name="project_name" id="project_name" class="form-control" value="{{ $settings['project_name'] }}" placeholder="Enter project name">
                                    @error('project_name')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="project_version" class="form-label">Project Version</label>
                                    <input type="text" name="project_version" id="project_version" class="form-control" value="{{ $settings['project_version'] }}" placeholder="1.0.0">
                                    @error('project_version')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-contacts-line me-2"></i>Contact Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contact_email" class="form-label">Contact Email</label>
                                    <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ $settings['contact_email'] }}" placeholder="contact@example.com">
                                    @error('contact_email')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_phone" class="form-label">Contact Phone</label>
                                    <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ $settings['contact_phone'] }}" placeholder="+91 1234567890">
                                    @error('contact_phone')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_mobile" class="form-label">Contact Mobile</label>
                                    <input type="text" name="contact_mobile" id="contact_mobile" class="form-control" value="{{ $settings['contact_mobile'] }}" placeholder="+91 9876543210">
                                    @error('contact_mobile')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="contact_address" class="form-label">Address</label>
                                    <textarea name="contact_address" id="contact_address" class="form-control" rows="3" placeholder="Enter full address">{{ $settings['contact_address'] }}</textarea>
                                    @error('contact_address')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="contact_city" class="form-label">City</label>
                                    <input type="text" name="contact_city" id="contact_city" class="form-control" value="{{ $settings['contact_city'] }}" placeholder="Enter city">
                                    @error('contact_city')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="contact_state" class="form-label">State</label>
                                    <input type="text" name="contact_state" id="contact_state" class="form-control" value="{{ $settings['contact_state'] }}" placeholder="Enter state">
                                    @error('contact_state')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="contact_country" class="form-label">Country</label>
                                    <input type="text" name="contact_country" id="contact_country" class="form-control" value="{{ $settings['contact_country'] }}" placeholder="Enter country">
                                    @error('contact_country')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_postal_code" class="form-label">Postal Code</label>
                                    <input type="text" name="contact_postal_code" id="contact_postal_code" class="form-control" value="{{ $settings['contact_postal_code'] }}" placeholder="Enter postal code">
                                    @error('contact_postal_code')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-share-line me-2"></i>Social Media Links
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="facebook_url" class="form-label">Facebook URL</label>
                                    <input type="url" name="facebook_url" id="facebook_url" class="form-control" value="{{ $settings['facebook_url'] }}" placeholder="https://facebook.com/yourpage">
                                    @error('facebook_url')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                    <input type="url" name="twitter_url" id="twitter_url" class="form-control" value="{{ $settings['twitter_url'] }}" placeholder="https://twitter.com/yourhandle">
                                    @error('twitter_url')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="instagram_url" class="form-label">Instagram URL</label>
                                    <input type="url" name="instagram_url" id="instagram_url" class="form-control" value="{{ $settings['instagram_url'] }}" placeholder="https://instagram.com/yourhandle">
                                    @error('instagram_url')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                    <input type="url" name="linkedin_url" id="linkedin_url" class="form-control" value="{{ $settings['linkedin_url'] }}" placeholder="https://linkedin.com/company/yourcompany">
                                    @error('linkedin_url')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="youtube_url" class="form-label">YouTube URL</label>
                                    <input type="url" name="youtube_url" id="youtube_url" class="form-control" value="{{ $settings['youtube_url'] }}" placeholder="https://youtube.com/channel/yourchannel">
                                    @error('youtube_url')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] }}" placeholder="+91 1234567890">
                                    @error('whatsapp_number')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branding & Logo -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-palette-line me-2"></i>Branding & Logo
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                    <small class="text-muted">Recommended size: 200x60px. Formats: JPG, PNG, SVG (Max: 2MB)</small>
                                    @if($settings['logo'])
                                        <div class="mt-2">
                                            <img src="{{ asset($settings['logo']) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 60px;">
                                        </div>
                                    @endif
                                    @error('logo')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*">
                                    <small class="text-muted">Recommended size: 32x32px. Formats: ICO, PNG (Max: 512KB)</small>
                                    @if($settings['favicon'])
                                        <div class="mt-2">
                                            <img src="{{ asset($settings['favicon']) }}" alt="Current Favicon" class="img-thumbnail" style="max-height: 32px;">
                                        </div>
                                    @endif
                                    @error('favicon')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="primary_color" class="form-label">Primary Color</label>
                                    <input type="color" name="primary_color" id="primary_color" class="form-control form-control-color" value="{{ $settings['primary_color'] }}">
                                    @error('primary_color')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="secondary_color" class="form-label">Secondary Color</label>
                                    <input type="color" name="secondary_color" id="secondary_color" class="form-control form-control-color" value="{{ $settings['secondary_color'] }}">
                                    @error('secondary_color')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="footer_text" class="form-label">Footer Text</label>
                                    <textarea name="footer_text" id="footer_text" class="form-control" rows="3" placeholder="Enter footer text">{{ $settings['footer_text'] }}</textarea>
                                    @error('footer_text')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="ri-close-line me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-2"></i>Save All Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

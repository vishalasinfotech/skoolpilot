@extends('layouts.master')
@section('title', 'White-label Customization')
@section('main-container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">White-label Customization</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                <li class="breadcrumb-item active">White-label Customization</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.badge')

            <form action="{{ route('school-admin.setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Branding Section -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-palette-line me-2"></i>Branding & Logo
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="school_logo" class="form-label">School Logo</label>
                                        <input type="file" name="school_logo" id="school_logo" class="form-control" accept="image/*">
                                        <small class="text-muted">Recommended size: 200x60px. Formats: JPG, PNG, SVG (Max: 2MB)</small>
                                        @if($defaults['school_logo'])
                                            <div class="mt-2">
                                                <img src="{{ asset($defaults['school_logo']) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 60px;">
                                            </div>
                                        @endif
                                        @error('school_logo')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="school_favicon" class="form-label">Favicon</label>
                                        <input type="file" name="school_favicon" id="school_favicon" class="form-control" accept="image/x-icon,image/png">
                                        <small class="text-muted">Recommended size: 32x32px. Formats: ICO, PNG (Max: 512KB)</small>
                                        @if($defaults['school_favicon'])
                                            <div class="mt-2">
                                                <img src="{{ asset($defaults['school_favicon']) }}" alt="Current Favicon" class="img-thumbnail" style="max-height: 32px;">
                                            </div>
                                        @endif
                                        @error('school_favicon')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="primary_color" class="form-label">Primary Color</label>
                                        <div class="input-group">
                                            <input type="color" name="primary_color" id="primary_color" class="form-control form-control-color" value="{{ $defaults['primary_color'] ?? '#6366f1' }}" title="Choose primary color">
                                            <input type="text" class="form-control" value="{{ $defaults['primary_color'] ?? '#6366f1' }}" id="primary_color_text" placeholder="#6366f1" readonly>
                                        </div>
                                        <small class="text-muted">Click the color box to choose a color</small>
                                        @error('primary_color')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="secondary_color" class="form-label">Secondary Color</label>
                                        <div class="input-group">
                                            <input type="color" name="secondary_color" id="secondary_color" class="form-control form-control-color" value="{{ $defaults['secondary_color'] ?? '#8b5cf6' }}" title="Choose secondary color">
                                            <input type="text" class="form-control" value="{{ $defaults['secondary_color'] ?? '#8b5cf6' }}" id="secondary_color_text" placeholder="#8b5cf6" readonly>
                                        </div>
                                        <small class="text-muted">Click the color box to choose a color</small>
                                        @error('secondary_color')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="school_name" class="form-label">School Name</label>
                                        <x-input type="text" name="school_name" id="school_name" :value="old('school_name', $defaults['school_name'])" placeholder="Enter school name" />
                                        @error('school_name')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="school_tagline" class="form-label">School Tagline</label>
                                        <x-input type="text" name="school_tagline" id="school_tagline" :value="old('school_tagline', $defaults['school_tagline'])" placeholder="Enter school tagline" />
                                        @error('school_tagline')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="footer_text" class="form-label">Footer Text</label>
                                        <x-textarea name="footer_text" id="footer_text" rows="2" placeholder="Enter footer text">{{ old('footer_text', $defaults['footer_text']) }}</x-textarea>
                                        @error('footer_text')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="col-lg-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-mail-line me-2"></i>Email Settings
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="mail_mailer" class="form-label">Mail Driver</label>
                                        <select name="mail_mailer" id="mail_mailer" class="form-select">
                                            <option value="smtp" {{ old('mail_mailer', $defaults['mail_mailer']) === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                            <option value="sendmail" {{ old('mail_mailer', $defaults['mail_mailer']) === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                            <option value="mailgun" {{ old('mail_mailer', $defaults['mail_mailer']) === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                            <option value="log" {{ old('mail_mailer', $defaults['mail_mailer']) === 'log' ? 'selected' : '' }}>Log (Testing)</option>
                                        </select>
                                        @error('mail_mailer')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="mail_host" class="form-label">Mail Host</label>
                                        <x-input type="text" name="mail_host" id="mail_host" :value="old('mail_host', $defaults['mail_host'])" placeholder="smtp.mailtrap.io" />
                                        <small class="text-muted">Required for SMTP</small>
                                        @error('mail_host')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="mail_port" class="form-label">Mail Port</label>
                                        <x-input type="number" name="mail_port" id="mail_port" :value="old('mail_port', $defaults['mail_port'])" placeholder="587" min="1" max="65535" />
                                        <small class="text-muted">Common: 587 (TLS), 465 (SSL), 2525</small>
                                        @error('mail_port')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="mail_username" class="form-label">Mail Username</label>
                                        <x-input type="text" name="mail_username" id="mail_username" :value="old('mail_username', $defaults['mail_username'])" placeholder="your-email@domain.com" />
                                        @error('mail_username')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="mail_password" class="form-label">Mail Password</label>
                                        <x-input type="password" name="mail_password" id="mail_password" value="" placeholder="Leave empty to keep current password" autocomplete="new-password" />
                                        <small class="text-muted">
                                            <i class="ri-information-line"></i> Leave empty to keep the current password. Only enter if you want to change it.
                                        </small>
                                        @error('mail_password')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="mail_encryption" class="form-label">Mail Encryption</label>
                                        <select name="mail_encryption" id="mail_encryption" class="form-select">
                                            <option value="tls" {{ old('mail_encryption', $defaults['mail_encryption']) === 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ old('mail_encryption', $defaults['mail_encryption']) === 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                        @error('mail_encryption')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="mail_from_address" class="form-label">From Address</label>
                                        <x-input type="email" name="mail_from_address" id="mail_from_address" :value="old('mail_from_address', $defaults['mail_from_address'])" placeholder="noreply@school.com" />
                                        <small class="text-muted">This email address will be used as the sender for all emails</small>
                                        @error('mail_from_address')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-lg-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-phone-line me-2"></i>Contact Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="support_email" class="form-label">Support Email</label>
                                        <x-input type="email" name="support_email" id="support_email" :value="old('support_email', $defaults['support_email'])" placeholder="support@school.com" />
                                        @error('support_email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="support_phone" class="form-label">Support Phone</label>
                                        <x-input type="text" name="support_phone" id="support_phone" :value="old('support_phone', $defaults['support_phone'])" placeholder="+1 234 567 8900" />
                                        @error('support_phone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <x-textarea name="address" id="address" rows="2" placeholder="Enter school address">{{ old('address', $defaults['address']) }}</x-textarea>
                                        @error('address')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="col-lg-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-share-line me-2"></i>Social Media Links
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="website_url" class="form-label">Website URL</label>
                                        <x-input type="url" name="website_url" id="website_url" :value="old('website_url', $defaults['website_url'])" placeholder="https://www.school.com" />
                                        @error('website_url')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="facebook_url" class="form-label">Facebook URL</label>
                                        <x-input type="url" name="facebook_url" id="facebook_url" :value="old('facebook_url', $defaults['facebook_url'])" placeholder="https://facebook.com/school" />
                                        @error('facebook_url')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="twitter_url" class="form-label">Twitter URL</label>
                                        <x-input type="url" name="twitter_url" id="twitter_url" :value="old('twitter_url', $defaults['twitter_url'])" placeholder="https://twitter.com/school" />
                                        @error('twitter_url')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="instagram_url" class="form-label">Instagram URL</label>
                                        <x-input type="url" name="instagram_url" id="instagram_url" :value="old('instagram_url', $defaults['instagram_url'])" placeholder="https://instagram.com/school" />
                                        @error('instagram_url')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                        <x-input type="url" name="linkedin_url" id="linkedin_url" :value="old('linkedin_url', $defaults['linkedin_url'])" placeholder="https://linkedin.com/company/school" />
                                        @error('linkedin_url')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-lg-12 mt-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line align-middle me-1"></i> Save Settings
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sync color picker with text input
        document.addEventListener('DOMContentLoaded', function() {
            const primaryColor = document.getElementById('primary_color');
            const primaryColorText = document.getElementById('primary_color_text');
            const secondaryColor = document.getElementById('secondary_color');
            const secondaryColorText = document.getElementById('secondary_color_text');

            if (primaryColor && primaryColorText) {
                primaryColor.addEventListener('input', function() {
                    primaryColorText.value = this.value;
                });
            }

            if (secondaryColor && secondaryColorText) {
                secondaryColor.addEventListener('input', function() {
                    secondaryColorText.value = this.value;
                });
            }
        });
    </script>
@endsection


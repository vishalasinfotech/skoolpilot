<?php

namespace App\Http\Requests\SchoolAdmin\Notification;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['school-admin', 'school_admin'], true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'url' => ['nullable', 'string', 'max:500'],
            'send_type' => ['required', 'string', 'in:role,user'],
            'roles' => ['required_if:send_type,role', 'array', 'min:1'],
            'roles.*' => ['string', 'in:teacher,student,parent,staff'],
            'user_ids' => ['required_if:send_type,user', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
            'notification_template_id' => ['nullable', 'integer', 'exists:notification_templates,id'],
            'send_email' => ['nullable', 'boolean'],
        ];
    }
}

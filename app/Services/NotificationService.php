<?php

namespace App\Services;

use App\Mail\NotificationMail;
use App\Models\CustomNotification;
use App\Models\NotificationRecipient;
use App\Models\NotificationTemplate;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\SchoolNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send notifications to users based on roles or specific user IDs.
     */
    public function sendNotification(
        int $schoolId,
        int $senderId,
        string $title,
        string $message,
        string $type,
        ?array $roles = null,
        ?array $userIds = null,
        ?string $url = null,
        ?int $templateId = null,
        bool $sendEmail = true
    ): CustomNotification {
        // Get recipients based on type
        $recipients = $this->getRecipients($schoolId, $type, $roles, $userIds);

        // Create notification record
        $notification = CustomNotification::create([
            'school_id' => $schoolId,
            'notification_template_id' => $templateId,
            'sender_id' => $senderId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'recipient_roles' => $roles,
            'recipient_user_ids' => $userIds,
            'total_recipients' => $recipients->count(),
            'url' => $url,
            'email_sent' => $sendEmail,
            'sent_at' => now(),
        ]);

        $emailsSent = 0;
        $emailsFailed = 0;

        // Send notifications to each recipient
        foreach ($recipients as $user) {
            // Create recipient record
            $recipient = NotificationRecipient::create([
                'notification_id' => $notification->id,
                'user_id' => $user->id,
            ]);

            // Send database notification
            try {
                $user->notify(new SchoolNotification(
                    title: $title,
                    message: $message,
                    url: $url
                ));
            } catch (\Exception $e) {
                Log::error('Failed to send database notification', [
                    'user_id' => $user->id,
                    'notification_id' => $notification->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Send email if requested
            if ($sendEmail && $user->email) {
                try {
                    // Configure mail settings from database
                    $this->configureMailSettings($schoolId);

                    $template = $templateId ? NotificationTemplate::find($templateId) : null;
                    $emailSubject = $template ? $this->replaceVariables($template->subject, $user) : $title;
                    $emailBody = $template ? $this->replaceVariables($template->body, $user) : $message;

                    Mail::to($user->email)->send(new NotificationMail(
                        mailSubject: $emailSubject,
                        body: $emailBody,
                        title: $title,
                        url: $url
                    ));

                    $recipient->update([
                        'email_sent' => true,
                        'email_sent_at' => now(),
                    ]);

                    $emailsSent++;
                } catch (\Exception $e) {
                    $recipient->update([
                        'email_error' => $e->getMessage(),
                    ]);

                    $emailsFailed++;
                    Log::error('Failed to send email notification', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'notification_id' => $notification->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        // Update notification with email statistics
        $notification->update([
            'emails_sent' => $emailsSent,
            'emails_failed' => $emailsFailed,
        ]);

        return $notification;
    }

    /**
     * Get recipients based on type, roles, or user IDs.
     */
    protected function getRecipients(int $schoolId, string $type, ?array $roles, ?array $userIds)
    {
        $query = User::where('school_id', $schoolId)
            ->where('is_active', true);

        if ($type === 'role' && $roles) {
            $query->whereIn('role', $roles);
        } elseif ($type === 'user' && $userIds) {
            $query->whereIn('id', $userIds);
        }

        return $query->get();
    }

    /**
     * Replace variables in template with user data.
     */
    protected function replaceVariables(string $text, User $user): string
    {
        $replacements = [
            '{{name}}' => $user->name ?? $user->full_name,
            '{{first_name}}' => $user->first_name ?? '',
            '{{last_name}}' => $user->last_name ?? '',
            '{{email}}' => $user->email ?? '',
            '{{role}}' => $user->role ?? '',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $text);
    }

    /**
     * Configure mail settings from database settings.
     */
    protected function configureMailSettings(int $schoolId): void
    {
        // Get mail settings from database
        $mailMailer = Setting::get('mail_mailer', config('mail.default'), $schoolId);
        $mailHost = Setting::get('mail_host', config('mail.mailers.smtp.host'), $schoolId);
        $mailPort = Setting::get('mail_port', config('mail.mailers.smtp.port'), $schoolId);
        $mailUsername = Setting::get('mail_username', config('mail.mailers.smtp.username'), $schoolId);
        $mailPassword = Setting::get('mail_password', config('mail.mailers.smtp.password'), $schoolId);
        $mailEncryption = Setting::get('mail_encryption', config('mail.mailers.smtp.encryption'), $schoolId);
        $mailFromName = Setting::get('mail_from_name', config('mail.from.name'), $schoolId);
        $mailFromAddress = Setting::get('mail_from_address', config('mail.from.address'), $schoolId);

        // Configure mail settings dynamically
        Config::set('mail.default', $mailMailer);

        // Configure SMTP settings if mailer is SMTP
        if ($mailMailer === 'smtp') {
            Config::set('mail.mailers.smtp.host', $mailHost);
            Config::set('mail.mailers.smtp.port', $mailPort);
            Config::set('mail.mailers.smtp.username', $mailUsername);
            Config::set('mail.mailers.smtp.password', $mailPassword);
            Config::set('mail.mailers.smtp.encryption', $mailEncryption);
        }

        // Configure from address
        Config::set('mail.from.address', $mailFromAddress);
        Config::set('mail.from.name', $mailFromName);
    }
}

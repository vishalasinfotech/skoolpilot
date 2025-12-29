<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #6366f1; padding: 30px; text-align: center; border-radius: 8px 8px 0 0;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">{{ $title }}</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <div style="color: #333333; font-size: 16px; line-height: 1.6;">
                                {!! nl2br(e($body)) !!}
                            </div>
                            @if($url)
                            <div style="margin-top: 30px; text-align: center;">
                                <a href="{{ url($url) }}" style="display: inline-block; padding: 12px 30px; background-color: #6366f1; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">View Details</a>
                            </div>
                            @endif
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 8px 8px; color: #666666; font-size: 12px;">
                            <p style="margin: 0;">This is an automated notification from {{ config('app.name') }}.</p>
                            <p style="margin: 5px 0 0 0;">Please do not reply to this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>


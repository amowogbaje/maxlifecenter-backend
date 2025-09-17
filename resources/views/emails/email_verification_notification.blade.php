@extends('emails._partials.layout')
@section('content')
<tr>
    <td style="padding-top: 32px;">
        <p style="margin: 0; font-size: 16px; font-weight: 500; color: #000000;">Hello {{ $user->full_name }},</p>
    </td>
</tr>

<tr>
    <td style="padding-top: 24px;">
        <p style="margin: 0; font-size: 14px; line-height: 22px; color: #000000;">
            Your verification code is:
            <br><br>
        </p>
    </td>
</tr>
<tr>
    <td style="padding: 20px 0; text-align: center;">
        <div style="padding-top: 0px; margin-top: 0px;">
            <span style="display: inline-block; font-size: 32px; font-weight: 800; letter-spacing: 2px; padding: 12px 24px; border-radius: 8px;">
                {{ $otp }}
            </span>
        </div>
    </td>
</tr>
<tr>
    <td style="padding-top: 12px;">
        <p style="margin: 0; font-size: 14px; line-height: 22px;">
            This one-time password is only valid for the next <span style="color: #B22222;">{{$minutes}} minutes</span>.    
        </p>
    </td>
</tr>


@endsection

@extends('emails._partials.layout')
@section('content')
<tr>
    <td style="padding-top: 32px;">
        <p style="margin: 0; font-size: 16px; font-weight: 500; color: #222222;">Hi {{ $user->getDisplayName() }},</p>
    </td>
</tr>

<tr>
    <td style="padding-top: 24px;">
        <p style="margin: 0; font-size: 14px; line-height: 22px; color: #222222;">
            We received a request to reset the password for your account. Please enter the code below in the app along with your new password.
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
            This code is only valid for <span style="color: #000000;"><b>{{$minutes}} minutes</b></span>.
        </p>
    </td>
</tr>

<tr>
    <td style="padding-top: 12px;">
        <p style="margin: 0; font-size: 14px; line-height: 22px;">
            If you didn't ask to reset your password, don't worry! Your password is still unchanged and you can ignore this email.    
        </p>
    </td>
</tr>

<tr>
    <td style="padding-top: 24px;">
        <p style="margin: 0; font-size: 14px; line-height: 22px; color: #222222;">
            Do your day right.
            <br><br>
            <span style="font-weight: 500; color: #076464;">The Dayout Team</span>
        </p>
    </td>
</tr>


@endsection

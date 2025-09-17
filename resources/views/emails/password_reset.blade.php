@extends('emails._partials.layout')

@section('content')
<tr>
    <td style="padding-top: 32px;">
        <p style="margin: 0; font-size: 16px; font-weight: 500; color: #222222;">
            Hi {{ $user->full_name }},
        </p>
    </td>
</tr>

<tr>
    <td style="padding-top: 24px;">
        <p style="margin: 0; font-size: 14px; line-height: 22px; color: #222222;">
            We received a request to reset the password for your account. 
            You can click the button to set a new password.
            <br><br>
        </p>
    </td>
</tr>



<!-- RESET LINK -->
<tr>
    <td style="padding-top: 20px; text-align: center;">
        <a href="{{ $resetUrl }}" 
           style="display: inline-block; padding: 12px 24px; font-size: 16px; 
                  font-weight: 600; color: #ffffff; background-color: #076464; 
                  text-decoration: none; border-radius: 6px;">
            Reset Password
        </a>
    </td>
</tr>

<tr>
    <td style="padding-top: 24px;">
        <p style="margin: 0; font-size: 14px; line-height: 22px; color: #222222;">
            If you didn’t request this, no action is needed — your password is still safe.
        </p>
    </td>
</tr>


@endsection

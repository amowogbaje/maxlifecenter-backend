

{{-- <tr>
    <td style="padding-top: 24px;;padding-bottom: 24px;  text-align: center; border-top: 1px solid #d9d9d9;">
        <div style="margin-top: 0px;">
            <a href="https://x.com/join{{ env('APP_NAME')}}" style="display: inline-block; margin: 0 8px;"><img src="{{ url('images/twitter_icon.png') }}" alt="Social Icon" style="width: 17px; height: 17px;"></a>
            <a href="https://www.linkedin.com/company/join-{{ env('APP_NAME')}}/" style="display: inline-block; margin: 0 8px;"><img src="{{ url('images/linkedin_icon.png') }}" alt="LinkedIn" style="width: 17px; height: 17px;"></a>
            <a href="https://www.instagram.com/join{{ env('APP_NAME')}}/" style="display: inline-block; margin: 0 8px;"><img src="{{ url('images/instagram_icon.png') }}" alt="Instagram" style="width: 17px; height: 17px;"></a>
        </div>
    </td>
</tr> --}}

<tr>
    <td style="padding-top: 24px; text-align: center;">
        <p style="margin: 24px 0 0 0; font-size: 10px; color: #222222; text-align:center">© {{date('Y')}} {{ env('APP_NAME')}}. All rights reserved.</p>
        <p style="margin: 24px 0 0 0; font-size: 10px; color: #555555; text-align:center">
            <a href="{{ url('about-us') }}" style="color: #555555; text-decoration: none; margin: 0 5px;"><u>About us</u></a>
            <a href="{{ env('APP_URL')}}/contact-us" style="color: #555555; text-decoration: none; margin: 0 5px;"><u>Contact Us</u></a>
            <a href="#" style="color: #555555; text-decoration: none; margin: 0 5px;"><u>Unsubscribe</u></a>
        </p>
    </td>
</tr>

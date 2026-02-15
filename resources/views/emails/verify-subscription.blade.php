<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirm Subscription</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9fafb; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" style="background:#ffffff; padding:24px; border-radius:8px;">
                    
                    <tr>
                        <td>
                            <h2 style="margin-top:0;">Confirm your subscription</h2>

                            <p>
                                You recently requested to subscribe to
                                <strong>{{ $subscription->name }}</strong>.
                            </p>

                            <p>
                                {{ $subscription->description }}
                            </p>

                            <p style="margin:30px 0; text-align:center;">
                                <a href="{{ $verifyUrl }}"
                                   style="
                                     background:#2563eb;
                                     color:#ffffff;
                                     padding:12px 24px;
                                     text-decoration:none;
                                     border-radius:6px;
                                     font-weight:bold;
                                   ">
                                    Confirm Subscription
                                </a>
                            </p>

                            <hr style="margin:30px 0;">

                            <h3>Recent posts this week</h3>

                            @forelse($recentBlogs as $blog)
                                <div style="margin-bottom:16px;">
                                    <strong>{{ $blog->title }}</strong>
                                    <p style="margin:4px 0;color:#555;">
                                        {{ Str::limit($blog->description, 120) }}
                                    </p>
                                </div>
                            @empty
                                <p>No new posts this week.</p>
                            @endforelse

                            <hr style="margin:30px 0;">

                            <p style="font-size:12px;color:#777;">
                                If you did not request this subscription,
                                you can safely ignore this email.
                            </p>

                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>

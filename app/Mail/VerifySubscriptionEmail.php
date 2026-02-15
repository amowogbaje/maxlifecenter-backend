<?php

namespace App\Mail;

use App\Models\Subscription;
use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifySubscriptionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $token,
        public Subscription $subscription
    ) {}

    public function build()
    {
        // Blogs from the last 7 days
        $recentBlogs = Blog::where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        return $this->subject('Confirm your subscription')
            ->view('emails.verify-subscription')
            ->with([
                'subscription' => $this->subscription,
                'recentBlogs'  => $recentBlogs,
                'verifyUrl'    => url("/subscriptions/verify/{$this->token}"),
            ]);
    }
}

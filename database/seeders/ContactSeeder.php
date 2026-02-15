<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $subscriptions = Subscription::all();

        Contact::factory()
            ->count(50)
            ->create()
            ->each(function ($contact) use ($subscriptions) {

                // Random subscriptions per contact
                $subscriptionIds = $subscriptions
                    ->random(rand(1, min(3, $subscriptions->count())))
                    ->pluck('id')
                    ->toArray();

                $contact->subscriptions()->syncWithoutDetaching($subscriptionIds);
            });
    }
}

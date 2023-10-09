<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Customer::class, function (Faker $faker) {
    return [
        'email' => $faker->safeEmail,
        'password' => '$2y$12$E6QUA2uiK7jE4PZwIhiQr.eOneMEikdKiFvKMAF5ss0VUZhBB6Sem',
        'customer_code' => $faker->randomNumber('4'),
        'customer_status_id' => 1,
    ];
});

$factory->afterCreating(App\Models\Customer::class, function ($customer, $faker) {
    $customer->contacts()->save(factory(App\Models\Contact::class)->make());
});

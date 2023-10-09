<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Contact::class, function (Faker $faker) {
    return [
        'contact_type_id' => 1,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address' => $faker->address,
        'city' => $faker->city,
        'postal_code' => $faker->postcode,
        'country_id' => $faker->numberBetween(1, 3),
        'email' => $faker->safeEmail,
    ];
});

<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {

    $gender =  array('female', 'male');

    return ['name' => $faker->name,
        'birthday' => $faker->date,
        'gender' => $gender[rand(0,1)],
        'picture' => null,
        'cpf' => $faker->numerify('###.###.###-##'),
        'email' => $faker->email,
        'user_id' => 1,
    ];
});

$factory->define(App\Models\Address::class, function (Faker\Generator $faker) {

    return [
        'customer_id' => rand(1,10),
        'zip_code' => $faker->postcode,
        'address' => $faker->name,
        'complement' => $faker->name,
        'number' => $faker->name,
        'city_id' => $faker->numberBetween(1,5000),
    ];
});
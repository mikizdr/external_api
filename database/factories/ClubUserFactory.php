<?php

use Faker\Generator as Faker;
use App\User;
use App\Models\Club;
use App\Models\Role;

$factory->define(App\ClubUser::class, function (Faker $faker) {
    $status = [
        'active', 'waiting', 'deleted'
    ];
    $rand_keys = array_rand($status, 3);

    return [
        'creator_id' => 1,
        'user_id' => rand(1, 200),
        // 'user_id' => function () {
        // 	return User::all()->random();
        // },
        'club_id' => rand(1, 100),
        // 'club_id' => function () {
        // 	return Club::all()->random();
        // },
        'role_id' => rand(1, 3),
        // 'role_id' => function () {
        // 	return Role::all()->random();
        // },
        'status' => $status[$rand_keys[rand(0, 2)]],
    ];
});

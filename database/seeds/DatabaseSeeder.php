<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('oauth_clients')->insert([
            'id' => '1',
            'name' => 'Infyom Personal Access Client',
            'secret' => 'xLPJw5Njg81RTJQeAlFQY81mj0QIyPH4Q969rjwV',
            'redirect' => 'http://localhost',
            'personal_access_client' => '1',
            'password_client' => '0',
            'revoked' => '0',
            'created_at' => '2020-02-21 10:21:35'
        ]);

        DB::table('oauth_clients')->insert([
            'id' => '2',
            'name' => 'Infyom Password Grant Client',
            'secret' => 'CDM9sh6rilKkqSB6hssHhFAK3jT7pz5htD2CcdAR',
            'redirect' => 'http://localhost',
            'personal_access_client' => '0',
            'password_client' => '1',
            'revoked' => '0',
            'created_at' => '2020-02-21 10:21:35'
        ]);
    }
}

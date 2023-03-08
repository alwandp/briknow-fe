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
        $this->call(UserSeeder::class);
        factory(\App\project::class,3)->create();
        factory(\App\document::class,3)->create();
        factory(\App\favorite_project::class,3)->create();
        factory(\App\favorite_consultant::class,3)->create();
        factory(\App\keywords::class,3)->create();
        factory(\App\search_log::class,3)->create();
        factory(\App\project_managers::class,3)->create();
        factory(\App\keywords_document::class,3)->create();
        factory(\App\consultant::class,3)->create();
        factory(\App\divisi::class,3)->create();
    }
}

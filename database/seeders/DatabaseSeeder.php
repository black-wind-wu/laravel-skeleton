<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $dbConnection = DB::connection();
        $autoIncrement = 10000000;
        $tables = [
            'users', 'user_social_accounts', 'user_login_history', 'messages', 'oauth_clients', 'articles', 'tags'
        ];
        if ($dbConnection->getConfig('driver') == 'mysql') {
            $tablePrefix = DB::connection()->getTablePrefix();
            foreach ($tables as $table) {
                DB::statement('ALTER TABLE ' . $tablePrefix . $table . ' AUTO_INCREMENT = ' . $autoIncrement);
            }
        }

        // \App\Models\User::factory(10)->create();
        $this->call(AdminSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(PassportSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(StopWordsSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(AdvertisementSeeder::class);
        $this->call(LinkSeeder::class);
    }
}

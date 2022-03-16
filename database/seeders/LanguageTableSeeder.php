<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'name' => 'العربية',
                'code' => 'ar'
            ],
            [
                'name' => 'English',
                'code' => 'en'
            ],
        ];

        foreach ($languages as $lang) {
            Language::create($lang);
         }
    }
}

<?php

use Illuminate\Database\Seeder;

class HomeslidersTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('homesliders_translation')->insert([
            'fk_language' => 1,
            'fk_homeslider' => 1,
            'title' => 'Patagonia excursion  es',
            'date' => 'Salida',
            'description' => 'bajada patagonia',
        ]);
        DB::table('homesliders_translation')->insert([
            'fk_language' => 2,
            'fk_homeslider' => 1,
            'name' => 'Patagonia excursion  en',
            'date' => 'Salida',
            'description' => 'description patagonia',
        ]);
        DB::table('homesliders_translation')->insert([
            'fk_language' => 3,
            'fk_homeslider' => 1,
            'name' => 'Patagonia excursion  pt',
            'date' => 'Salida',
            'description' => 'linha de queda patagonia',
        ]);
        DB::table('homesliders_translation')->insert([
            'fk_language' => 1,
            'fk_homeslider' => 2,
            'name' => 'Antartida excursion  es',
            'date' => 'Salida',
            'description' => 'bajada Antartida excursion ',            
        ]);
        DB::table('homesliders_translation')->insert([
            'fk_language' => 2,
            'fk_homeslider' => 2,
            'name' => 'Antartida excursion  en',
            'date' => 'Salida',
            'description' => 'description Antartida excursion ',  
        ]);
        DB::table('homesliders_translation')->insert([
            'fk_language' => 3,
            'fk_homeslider' => 2,
            'name' => 'Antartida excursion  pt',
            'date' => 'Salida',
            'description' => 'linha de queda Antartida excursion ',  
        ]);                  
    }
}

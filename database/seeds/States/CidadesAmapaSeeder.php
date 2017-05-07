<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesAmapaSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
        	['name' => 'Amapá', 'state_id' => 3],
			['name' => 'Calçoene', 'state_id' => 3],
			['name' => 'Cutias', 'state_id' => 3],
			['name' => 'Ferreira Gomes', 'state_id' => 3],
			['name' => 'Itaubal', 'state_id' => 3],
			['name' => 'Laranjal do Jari', 'state_id' => 3],
			['name' => 'Macapá', 'state_id' => 3],
			['name' => 'Mazagão', 'state_id' => 3],
			['name' => 'Oiapoque', 'state_id' => 3],
			['name' => 'Pedra Branca do Amaparí', 'state_id' => 3],
			['name' => 'Porto Grande', 'state_id' => 3],
			['name' => 'Pracuúba', 'state_id' => 3],
			['name' => 'Santana', 'state_id' => 3],
			['name' => 'Serra do Navio', 'state_id' => 3],
			['name' => 'Tartarugalzinho', 'state_id' => 3],
			['name' => 'Vitória do Jari', 'state_id' => 3]
        ]);

        $this->command->info('Cidades do Amapá importadas com sucesso!');
    }
}
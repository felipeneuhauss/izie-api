<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesAcreSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'Acrelândia', 'state_id' => 1],
            ['name' => 'Assis Brasil', 'state_id' => 1],
            ['name' => 'Brasiléia', 'state_id' => 1],
            ['name' => 'Bujari', 'state_id' => 1],
            ['name' => 'Capixaba', 'state_id' => 1],
            ['name' => 'Cruzeiro do Sul', 'state_id' => 1],
            ['name' => 'Epitaciolândia', 'state_id' => 1],
            ['name' => 'Feijó', 'state_id' => 1],
            ['name' => 'Jordão', 'state_id' => 1],
            ['name' => 'Mâncio Lima', 'state_id' => 1],
            ['name' => 'Manoel Urbano', 'state_id' => 1],
            ['name' => 'Marechal Thaumaturgo', 'state_id' => 1],
            ['name' => 'Plácido de Castro', 'state_id' => 1],
            ['name' => 'Porto Acre', 'state_id' => 1],
            ['name' => 'Porto Walter', 'state_id' => 1],
            ['name' => 'Rio Branco', 'state_id' => 1],
            ['name' => 'Rodrigues Alves', 'state_id' => 1],
            ['name' => 'Santa Rosa do Purus', 'state_id' => 1],
            ['name' => 'Sena Madureira', 'state_id' => 1],
            ['name' => 'Senador Guiomard', 'state_id' => 1],
            ['name' => 'Tarauacá', 'state_id' => 1],
            ['name' => 'Xapuri', 'state_id' => 1]
        ]);

        $this->command->info('Cidades do Acre importadas com sucesso!');
    }
}
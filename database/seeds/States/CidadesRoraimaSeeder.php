<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesRoraimaSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
        	['name' => 'Alto Alegre', 'state_id' => 23],
            ['name' => 'Amajari', 'state_id' => 23],
            ['name' => 'Boa Vista', 'state_id' => 23],
            ['name' => 'Bonfim', 'state_id' => 23],
            ['name' => 'Cantá', 'state_id' => 23],
            ['name' => 'Caracaraí', 'state_id' => 23],
            ['name' => 'Caroebe', 'state_id' => 23],
            ['name' => 'Iracema', 'state_id' => 23],
            ['name' => 'Mucajaí', 'state_id' => 23],
            ['name' => 'Normandia', 'state_id' => 23],
            ['name' => 'Pacaraima', 'state_id' => 23],
            ['name' => 'Rorainópolis', 'state_id' => 23],
            ['name' => 'São João da Baliza', 'state_id' => 23],
            ['name' => 'São Luiz', 'state_id' => 23],
            ['name' => 'Uiramutã', 'state_id' => 23]
        ]);

        $this->command->info('Cidades de Roraima importadas com sucesso!');
    }
}
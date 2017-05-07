<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesRondoniaSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
        	['name' => 'Alta Floresta d`Oeste', 'state_id' => 22],
            ['name' => 'Alto Alegre dos Parecis', 'state_id' => 22],
            ['name' => 'Alto Paraíso', 'state_id' => 22],
            ['name' => 'Alvorada d`Oeste', 'state_id' => 22],
            ['name' => 'Ariquemes', 'state_id' => 22],
            ['name' => 'Buritis', 'state_id' => 22],
            ['name' => 'Cabixi', 'state_id' => 22],
            ['name' => 'Cacaulândia', 'state_id' => 22],
            ['name' => 'Cacoal', 'state_id' => 22],
            ['name' => 'Campo Novo de Rondônia', 'state_id' => 22],
            ['name' => 'Candeias do Jamari', 'state_id' => 22],
            ['name' => 'Castanheiras', 'state_id' => 22],
            ['name' => 'Cerejeiras', 'state_id' => 22],
            ['name' => 'Chupinguaia', 'state_id' => 22],
            ['name' => 'Colorado do Oeste', 'state_id' => 22],
            ['name' => 'Corumbiara', 'state_id' => 22],
            ['name' => 'Costa Marques', 'state_id' => 22],
            ['name' => 'Cujubim', 'state_id' => 22],
            ['name' => 'Espigão d`Oeste', 'state_id' => 22],
            ['name' => 'Governador Jorge Teixeira', 'state_id' => 22],
            ['name' => 'Guajará-Mirim', 'state_id' => 22],
            ['name' => 'Itapuã do Oeste', 'state_id' => 22],
            ['name' => 'Jaru', 'state_id' => 22],
            ['name' => 'Ji-Paraná', 'state_id' => 22],
            ['name' => 'Machadinho d`Oeste', 'state_id' => 22],
            ['name' => 'Ministro Andreazza', 'state_id' => 22],
            ['name' => 'Mirante da Serra', 'state_id' => 22],
            ['name' => 'Monte Negro', 'state_id' => 22],
            ['name' => 'Nova Brasilândia d`Oeste', 'state_id' => 22],
            ['name' => 'Nova Mamoré', 'state_id' => 22],
            ['name' => 'Nova União', 'state_id' => 22],
            ['name' => 'Novo Horizonte do Oeste', 'state_id' => 22],
            ['name' => 'Ouro Preto do Oeste', 'state_id' => 22],
            ['name' => 'Parecis', 'state_id' => 22],
            ['name' => 'Pimenta Bueno', 'state_id' => 22],
            ['name' => 'Pimenteiras do Oeste', 'state_id' => 22],
            ['name' => 'Porto Velho', 'state_id' => 22],
            ['name' => 'Presidente Médici', 'state_id' => 22],
            ['name' => 'Primavera de Rondônia', 'state_id' => 22],
            ['name' => 'Rio Crespo', 'state_id' => 22],
            ['name' => 'Rolim de Moura', 'state_id' => 22],
            ['name' => 'Santa Luzia d`Oeste', 'state_id' => 22],
            ['name' => 'São Felipe d`Oeste', 'state_id' => 22],
            ['name' => 'São Francisco do Guaporé', 'state_id' => 22],
            ['name' => 'São Miguel do Guaporé', 'state_id' => 22],
            ['name' => 'Seringueiras', 'state_id' => 22],
            ['name' => 'Teixeirópolis', 'state_id' => 22],
            ['name' => 'Theobroma', 'state_id' => 22],
            ['name' => 'Urupá', 'state_id' => 22],
            ['name' => 'Vale do Anari', 'state_id' => 22],
            ['name' => 'Vale do Paraíso', 'state_id' => 22],
            ['name' => 'Vilhena', 'state_id' => 22]
        ]);

        $this->command->info('Cidades de Rondônia importadas com sucesso!');
    }
}
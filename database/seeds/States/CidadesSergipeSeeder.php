<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesSergipeSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
        	['name' => 'Amparo de São Francisco', 'state_id' => 26],
            ['name' => 'Aquidabã', 'state_id' => 26],
            ['name' => 'Aracaju', 'state_id' => 26],
            ['name' => 'Arauá', 'state_id' => 26],
            ['name' => 'Areia Branca', 'state_id' => 26],
            ['name' => 'Barra dos Coqueiros', 'state_id' => 26],
            ['name' => 'Boquim', 'state_id' => 26],
            ['name' => 'Brejo Grande', 'state_id' => 26],
            ['name' => 'Campo do Brito', 'state_id' => 26],
            ['name' => 'Canhoba', 'state_id' => 26],
            ['name' => 'Canindé de São Francisco', 'state_id' => 26],
            ['name' => 'Capela', 'state_id' => 26],
            ['name' => 'Carira', 'state_id' => 26],
            ['name' => 'Carmópolis', 'state_id' => 26],
            ['name' => 'Cedro de São João', 'state_id' => 26],
            ['name' => 'Cristinápolis', 'state_id' => 26],
            ['name' => 'Cumbe', 'state_id' => 26],
            ['name' => 'Divina Pastora', 'state_id' => 26],
            ['name' => 'Estância', 'state_id' => 26],
            ['name' => 'Feira Nova', 'state_id' => 26],
            ['name' => 'Frei Paulo', 'state_id' => 26],
            ['name' => 'Gararu', 'state_id' => 26],
            ['name' => 'General Maynard', 'state_id' => 26],
            ['name' => 'Gracho Cardoso', 'state_id' => 26],
            ['name' => 'Ilha das Flores', 'state_id' => 26],
            ['name' => 'Indiaroba', 'state_id' => 26],
            ['name' => 'Itabaiana', 'state_id' => 26],
            ['name' => 'Itabaianinha', 'state_id' => 26],
            ['name' => 'Itabi', 'state_id' => 26],
            ['name' => 'Itaporanga d`Ajuda', 'state_id' => 26],
            ['name' => 'Japaratuba', 'state_id' => 26],
            ['name' => 'Japoatã', 'state_id' => 26],
            ['name' => 'Lagarto', 'state_id' => 26],
            ['name' => 'Laranjeiras', 'state_id' => 26],
            ['name' => 'Macambira', 'state_id' => 26],
            ['name' => 'Malhada dos Bois', 'state_id' => 26],
            ['name' => 'Malhador', 'state_id' => 26],
            ['name' => 'Maruim', 'state_id' => 26],
            ['name' => 'Moita Bonita', 'state_id' => 26],
            ['name' => 'Monte Alegre de Sergipe', 'state_id' => 26],
            ['name' => 'Muribeca', 'state_id' => 26],
            ['name' => 'Neópolis', 'state_id' => 26],
            ['name' => 'Nossa Senhora Aparecida', 'state_id' => 26],
            ['name' => 'Nossa Senhora da Glória', 'state_id' => 26],
            ['name' => 'Nossa Senhora das Dores', 'state_id' => 26],
            ['name' => 'Nossa Senhora de Lourdes', 'state_id' => 26],
            ['name' => 'Nossa Senhora do Socorro', 'state_id' => 26],
            ['name' => 'Pacatuba', 'state_id' => 26],
            ['name' => 'Pedra Mole', 'state_id' => 26],
            ['name' => 'Pedrinhas', 'state_id' => 26],
            ['name' => 'Pinhão', 'state_id' => 26],
            ['name' => 'Pirambu', 'state_id' => 26],
            ['name' => 'Poço Redondo', 'state_id' => 26],
            ['name' => 'Poço Verde', 'state_id' => 26],
            ['name' => 'Porto da Folha', 'state_id' => 26],
            ['name' => 'Propriá', 'state_id' => 26],
            ['name' => 'Riachão do Dantas', 'state_id' => 26],
            ['name' => 'Riachuelo', 'state_id' => 26],
            ['name' => 'Ribeirópolis', 'state_id' => 26],
            ['name' => 'Rosário do Catete', 'state_id' => 26],
            ['name' => 'Salgado', 'state_id' => 26],
            ['name' => 'Santa Luzia do Itanhy', 'state_id' => 26],
            ['name' => 'Santa Rosa de Lima', 'state_id' => 26],
            ['name' => 'Santana do São Francisco', 'state_id' => 26],
            ['name' => 'Santo Amaro das Brotas', 'state_id' => 26],
            ['name' => 'São Cristóvão', 'state_id' => 26],
            ['name' => 'São Domingos', 'state_id' => 26],
            ['name' => 'São Francisco', 'state_id' => 26],
            ['name' => 'São Miguel do Aleixo', 'state_id' => 26],
            ['name' => 'Simão Dias', 'state_id' => 26],
            ['name' => 'Siriri', 'state_id' => 26],
            ['name' => 'Telha', 'state_id' => 26],
            ['name' => 'Tobias Barreto', 'state_id' => 26],
            ['name' => 'Tomar do Geru', 'state_id' => 26],
            ['name' => 'Umbaúba', 'state_id' => 26]
        ]);

        $this->command->info('Cidades de Sergipe importadas com sucesso!');
    }
}
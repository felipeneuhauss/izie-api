<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesMatoGrossoDoSulSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
        	['name' => 'Água Clara', 'state_id' => 12],
            ['name' => 'Alcinópolis', 'state_id' => 12],
            ['name' => 'Amambaí', 'state_id' => 12],
            ['name' => 'Anastácio', 'state_id' => 12],
            ['name' => 'Anaurilândia', 'state_id' => 12],
            ['name' => 'Angélica', 'state_id' => 12],
            ['name' => 'Antônio João', 'state_id' => 12],
            ['name' => 'Aparecida do Taboado', 'state_id' => 12],
            ['name' => 'Aquidauana', 'state_id' => 12],
            ['name' => 'Aral Moreira', 'state_id' => 12],
            ['name' => 'Bandeirantes', 'state_id' => 12],
            ['name' => 'Bataguassu', 'state_id' => 12],
            ['name' => 'Bataiporã', 'state_id' => 12],
            ['name' => 'Bela Vista', 'state_id' => 12],
            ['name' => 'Bodoquena', 'state_id' => 12],
            ['name' => 'Bonito', 'state_id' => 12],
            ['name' => 'Brasilândia', 'state_id' => 12],
            ['name' => 'Caarapó', 'state_id' => 12],
            ['name' => 'Camapuã', 'state_id' => 12],
            ['name' => 'Campo Grande', 'state_id' => 12],
            ['name' => 'Caracol', 'state_id' => 12],
            ['name' => 'Cassilândia', 'state_id' => 12],
            ['name' => 'Chapadão do Sul', 'state_id' => 12],
            ['name' => 'Corguinho', 'state_id' => 12],
            ['name' => 'Coronel Sapucaia', 'state_id' => 12],
            ['name' => 'Corumbá', 'state_id' => 12],
            ['name' => 'Costa Rica', 'state_id' => 12],
            ['name' => 'Coxim', 'state_id' => 12],
            ['name' => 'Deodápolis', 'state_id' => 12],
            ['name' => 'Dois Irmãos do Buriti', 'state_id' => 12],
            ['name' => 'Douradina', 'state_id' => 12],
            ['name' => 'Dourados', 'state_id' => 12],
            ['name' => 'Eldorado', 'state_id' => 12],
            ['name' => 'Fátima do Sul', 'state_id' => 12],
            ['name' => 'Figueirão', 'state_id' => 12],
            ['name' => 'Glória de Dourados', 'state_id' => 12],
            ['name' => 'Guia Lopes da Laguna', 'state_id' => 12],
            ['name' => 'Iguatemi', 'state_id' => 12],
            ['name' => 'Inocência', 'state_id' => 12],
            ['name' => 'Itaporã', 'state_id' => 12],
            ['name' => 'Itaquiraí', 'state_id' => 12],
            ['name' => 'Ivinhema', 'state_id' => 12],
            ['name' => 'Japorã', 'state_id' => 12],
            ['name' => 'Jaraguari', 'state_id' => 12],
            ['name' => 'Jardim', 'state_id' => 12],
            ['name' => 'Jateí', 'state_id' => 12],
            ['name' => 'Juti', 'state_id' => 12],
            ['name' => 'Ladário', 'state_id' => 12],
            ['name' => 'Laguna Carapã', 'state_id' => 12],
            ['name' => 'Maracaju', 'state_id' => 12],
            ['name' => 'Miranda', 'state_id' => 12],
            ['name' => 'Mundo Novo', 'state_id' => 12],
            ['name' => 'Naviraí', 'state_id' => 12],
            ['name' => 'Nioaque', 'state_id' => 12],
            ['name' => 'Nova Alvorada do Sul', 'state_id' => 12],
            ['name' => 'Nova Andradina', 'state_id' => 12],
            ['name' => 'Novo Horizonte do Sul', 'state_id' => 12],
            ['name' => 'Paranaíba', 'state_id' => 12],
            ['name' => 'Paranhos', 'state_id' => 12],
            ['name' => 'Pedro Gomes', 'state_id' => 12],
            ['name' => 'Ponta Porã', 'state_id' => 12],
            ['name' => 'Porto Murtinho', 'state_id' => 12],
            ['name' => 'Ribas do Rio Pardo', 'state_id' => 12],
            ['name' => 'Rio Brilhante', 'state_id' => 12],
            ['name' => 'Rio Negro', 'state_id' => 12],
            ['name' => 'Rio Verde de Mato Grosso', 'state_id' => 12],
            ['name' => 'Rochedo', 'state_id' => 12],
            ['name' => 'Santa Rita do Pardo', 'state_id' => 12],
            ['name' => 'São Gabriel do Oeste', 'state_id' => 12],
            ['name' => 'Selvíria', 'state_id' => 12],
            ['name' => 'Sete Quedas', 'state_id' => 12],
            ['name' => 'Sidrolândia', 'state_id' => 12],
            ['name' => 'Sonora', 'state_id' => 12],
            ['name' => 'Tacuru', 'state_id' => 12],
            ['name' => 'Taquarussu', 'state_id' => 12],
            ['name' => 'Terenos', 'state_id' => 12],
            ['name' => 'Três Lagoas', 'state_id' => 12],
            ['name' => 'Vicentina', 'state_id' => 12]
        ]);

        $this->command->info('Cidades do Mato Grosso do Sul importadas com sucesso!');
    }
}
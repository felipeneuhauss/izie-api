<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesAmazonasSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
        	['name' => 'Alvarães', 'state_id' => 4],
            ['name' => 'Amaturá', 'state_id' => 4],
            ['name' => 'Anamã', 'state_id' => 4],
            ['name' => 'Anori', 'state_id' => 4],
            ['name' => 'Apuí', 'state_id' => 4],
            ['name' => 'Atalaia do Norte', 'state_id' => 4],
            ['name' => 'Autazes', 'state_id' => 4],
            ['name' => 'Barcelos', 'state_id' => 4],
            ['name' => 'Barreirinha', 'state_id' => 4],
            ['name' => 'Benjamin Constant', 'state_id' => 4],
            ['name' => 'Beruri', 'state_id' => 4],
            ['name' => 'Boa Vista do Ramos', 'state_id' => 4],
            ['name' => 'Boca do Acre', 'state_id' => 4],
            ['name' => 'Borba', 'state_id' => 4],
            ['name' => 'Caapiranga', 'state_id' => 4],
            ['name' => 'Canutama', 'state_id' => 4],
            ['name' => 'Carauari', 'state_id' => 4],
            ['name' => 'Careiro', 'state_id' => 4],
            ['name' => 'Careiro da Várzea', 'state_id' => 4],
            ['name' => 'Coari', 'state_id' => 4],
            ['name' => 'Codajás', 'state_id' => 4],
            ['name' => 'Eirunepé', 'state_id' => 4],
            ['name' => 'Envira', 'state_id' => 4],
            ['name' => 'Fonte Boa', 'state_id' => 4],
            ['name' => 'Guajará', 'state_id' => 4],
            ['name' => 'Humaitá', 'state_id' => 4],
            ['name' => 'Ipixuna', 'state_id' => 4],
            ['name' => 'Iranduba', 'state_id' => 4],
            ['name' => 'Itacoatiara', 'state_id' => 4],
            ['name' => 'Itamarati', 'state_id' => 4],
            ['name' => 'Itapiranga', 'state_id' => 4],
            ['name' => 'Japurá', 'state_id' => 4],
            ['name' => 'Juruá', 'state_id' => 4],
            ['name' => 'Jutaí', 'state_id' => 4],
            ['name' => 'Lábrea', 'state_id' => 4],
            ['name' => 'Manacapuru', 'state_id' => 4],
            ['name' => 'Manaquiri', 'state_id' => 4],
            ['name' => 'Manaus', 'state_id' => 4],
            ['name' => 'Manicoré', 'state_id' => 4],
            ['name' => 'Maraã', 'state_id' => 4],
            ['name' => 'Maués', 'state_id' => 4],
            ['name' => 'Nhamundá', 'state_id' => 4],
            ['name' => 'Nova Olinda do Norte', 'state_id' => 4],
            ['name' => 'Novo Airão', 'state_id' => 4],
            ['name' => 'Novo Aripuanã', 'state_id' => 4],
            ['name' => 'Parintins', 'state_id' => 4],
            ['name' => 'Pauini', 'state_id' => 4],
            ['name' => 'Presidente Figueiredo', 'state_id' => 4],
            ['name' => 'Rio Preto da Eva', 'state_id' => 4],
            ['name' => 'Santa Isabel do Rio Negro', 'state_id' => 4],
            ['name' => 'Santo Antônio do Içá', 'state_id' => 4],
            ['name' => 'São Gabriel da Cachoeira', 'state_id' => 4],
            ['name' => 'São Paulo de Olivença', 'state_id' => 4],
            ['name' => 'São Sebastião do Uatumã', 'state_id' => 4],
            ['name' => 'Silves', 'state_id' => 4],
            ['name' => 'Tabatinga', 'state_id' => 4],
            ['name' => 'Tapauá', 'state_id' => 4],
            ['name' => 'Tefé', 'state_id' => 4],
            ['name' => 'Tonantins', 'state_id' => 4],
            ['name' => 'Uarini', 'state_id' => 4],
            ['name' => 'Urucará', 'state_id' => 4],
            ['name' => 'Urucurituba', 'state_id' => 4]
        ]);

        $this->command->info('Cidades do Amazonas importadas com sucesso!');
    }
}
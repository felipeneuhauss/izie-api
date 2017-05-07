<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CidadesEspiritoSantoSeeder extends Seeder {

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('cities')->insert([
        	['name' => 'Afonso Cláudio', 'state_id' => 8],
            ['name' => 'Água Doce do Norte', 'state_id' => 8],
            ['name' => 'Águia Branca', 'state_id' => 8],
            ['name' => 'Alegre', 'state_id' => 8],
            ['name' => 'Alfredo Chaves', 'state_id' => 8],
            ['name' => 'Alto Rio Novo', 'state_id' => 8],
            ['name' => 'Anchieta', 'state_id' => 8],
            ['name' => 'Apiacá', 'state_id' => 8],
            ['name' => 'Aracruz', 'state_id' => 8],
            ['name' => 'Atilio Vivacqua', 'state_id' => 8],
            ['name' => 'Baixo Guandu', 'state_id' => 8],
            ['name' => 'Barra de São Francisco', 'state_id' => 8],
            ['name' => 'Boa Esperança', 'state_id' => 8],
            ['name' => 'Bom Jesus do Norte', 'state_id' => 8],
            ['name' => 'Brejetuba', 'state_id' => 8],
            ['name' => 'Cachoeiro de Itapemirim', 'state_id' => 8],
            ['name' => 'Cariacica', 'state_id' => 8],
            ['name' => 'Castelo', 'state_id' => 8],
            ['name' => 'Colatina', 'state_id' => 8],
            ['name' => 'Conceição da Barra', 'state_id' => 8],
            ['name' => 'Conceição do Castelo', 'state_id' => 8],
            ['name' => 'Divino de São Lourenço', 'state_id' => 8],
            ['name' => 'Domingos Martins', 'state_id' => 8],
            ['name' => 'Dores do Rio Preto', 'state_id' => 8],
            ['name' => 'Ecoporanga', 'state_id' => 8],
            ['name' => 'Fundão', 'state_id' => 8],
            ['name' => 'Governador Lindenberg', 'state_id' => 8],
            ['name' => 'Guaçuí', 'state_id' => 8],
            ['name' => 'Guarapari', 'state_id' => 8],
            ['name' => 'Ibatiba', 'state_id' => 8],
            ['name' => 'Ibiraçu', 'state_id' => 8],
            ['name' => 'Ibitirama', 'state_id' => 8],
            ['name' => 'Iconha', 'state_id' => 8],
            ['name' => 'Irupi', 'state_id' => 8],
            ['name' => 'Itaguaçu', 'state_id' => 8],
            ['name' => 'Itapemirim', 'state_id' => 8],
            ['name' => 'Itarana', 'state_id' => 8],
            ['name' => 'Iúna', 'state_id' => 8],
            ['name' => 'Jaguaré', 'state_id' => 8],
            ['name' => 'Jerônimo Monteiro', 'state_id' => 8],
            ['name' => 'João Neiva', 'state_id' => 8],
            ['name' => 'Laranja da Terra', 'state_id' => 8],
            ['name' => 'Linhares', 'state_id' => 8],
            ['name' => 'Mantenópolis', 'state_id' => 8],
            ['name' => 'Marataízes', 'state_id' => 8],
            ['name' => 'Marechal Floriano', 'state_id' => 8],
            ['name' => 'Marilândia', 'state_id' => 8],
            ['name' => 'Mimoso do Sul', 'state_id' => 8],
            ['name' => 'Montanha', 'state_id' => 8],
            ['name' => 'Mucurici', 'state_id' => 8],
            ['name' => 'Muniz Freire', 'state_id' => 8],
            ['name' => 'Muqui', 'state_id' => 8],
            ['name' => 'Nova Venécia', 'state_id' => 8],
            ['name' => 'Pancas', 'state_id' => 8],
            ['name' => 'Pedro Canário', 'state_id' => 8],
            ['name' => 'Pinheiros', 'state_id' => 8],
            ['name' => 'Piúma', 'state_id' => 8],
            ['name' => 'Ponto Belo', 'state_id' => 8],
            ['name' => 'Presidente Kennedy', 'state_id' => 8],
            ['name' => 'Rio Bananal', 'state_id' => 8],
            ['name' => 'Rio Novo do Sul', 'state_id' => 8],
            ['name' => 'Santa Leopoldina', 'state_id' => 8],
            ['name' => 'Santa Maria de Jetibá', 'state_id' => 8],
            ['name' => 'Santa Teresa', 'state_id' => 8],
            ['name' => 'São Domingos do Norte', 'state_id' => 8],
            ['name' => 'São Gabriel da Palha', 'state_id' => 8],
            ['name' => 'São José do Calçado', 'state_id' => 8],
            ['name' => 'São Mateus', 'state_id' => 8],
            ['name' => 'São Roque do Canaã', 'state_id' => 8],
            ['name' => 'Serra', 'state_id' => 8],
            ['name' => 'Sooretama', 'state_id' => 8],
            ['name' => 'Vargem Alta', 'state_id' => 8],
            ['name' => 'Venda Nova do Imigrante', 'state_id' => 8],
            ['name' => 'Viana', 'state_id' => 8],
            ['name' => 'Vila Pavão', 'state_id' => 8],
            ['name' => 'Vila Valério', 'state_id' => 8],
            ['name' => 'Vila Velha', 'state_id' => 8],
            ['name' => 'Vitória', 'state_id' => 8]
        ]);

        $this->command->info('Cidades do Espírito Santo importadas com sucesso!');
    }
}
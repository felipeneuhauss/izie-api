
php artisan make:migration create_users_table --create=users

php artisan make:migration add_votes_to_users_table --table=users

php artisan migrate:refresh --seed

php artisan migrate:refresh


php artisan make:seeder UsersTableSeeder

-- Caso de erro
-- [ReflectionException]
-- Class UserTableSeeder does not exist
$ composer.phar dump-autoload

-- Caso deseja recriar o banco de dados e gerar novos registros
php artisan migrate:refresh --seed

-- Criar
php artisan make:seeder CustomerTableSeeder

-- Rodar
php artisan db:seed --class=UsersTableSeeder


php artisan make:migration create_users_table --create=users

php artisan make:migration add_votes_to_users_table --table=users

php artisan migrate:refresh --seed

php artisan migrate:refresh



/**
 * Salva as categorias
 */
if (count($categories)) {
    // Remove as categorias
    \App\Models\ProductCategory::where('product_id', $vo->id)->delete();
    foreach ($categories as $category) {
        // Pega o objeto da categoria
        $categoryVo = \App\Models\Category::find($category);

        $vo->categories()->save($categoryVo);
    }
}

--
$table->foreign('state_id')->references('id')->on('states');
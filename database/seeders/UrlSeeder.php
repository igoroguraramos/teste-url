<?php

namespace Database\Seeders;

use App\Models\Url;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class UrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = Url::class;

        $url::create([
            'id_usuario' => 1,
            'url' => 'https://www.globo.com/',
            'resposta' => $this->exemploConteudo(),
            'status_code' => 200,
        ]);
    }

    private function exemploConteudo(){
        $response = Http::withOptions(['verify' => false])->get('https://www.globo.com/');
        return $response->body();
    }
}

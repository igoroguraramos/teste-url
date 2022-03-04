<?php

namespace App\Console\Commands;

use App\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class BotCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Url::all()->map(function($url){
            $dados = [];
            if($url->url != ""){
                $response = Http::withOptions(['verify' => false])->get($url->url);
                if($response->status() == 200){
                    $dados['resposta'] = $response->body();
                    $dados['status_code'] = $response->status();
                    Url::find($url->id)->update($dados);
                }
            }else{
                $dados['resposta'] = '';
                $dados['status_code'] = 404;
                Url::find($url->id)->update($dados);
            }
        });
    }
}

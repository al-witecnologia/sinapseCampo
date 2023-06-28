<?php

namespace App\Console\Commands;

use App\Models\Arquivo;
use App\Models\Parametro;
use App\Models\Registro;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UploadRegistros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:registros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia os registros para o servidor';


    public function enviar(){
        
        $parametro = Parametro::find(1);

        $responses = [];

        $arquivos = Arquivo::where([
            ['enviado_em','=', null]
        ])->get();

        if(count($arquivos)<=0){
            echo "Sem arquivos para enviar";
        }
        else{
            foreach($arquivos as $arquivo){     
                
                $content = Storage::get($arquivo->nome);

                $response = Http::withToken($parametro->token)->attach('arquivo', $content, $arquivo->nome)->post($parametro->path);
                
                if($response->successful()){
                    if($response->json('hash') == $arquivo->hash){
                        $arquivo->enviado_em    = Carbon::now();
                        $arquivo->save();                    
                    }


                    $upload = Upload::create([
                        'arquivo_id'    =>  $arquivo->id,
                        'response'      =>  $response->json('hash')                    
                    ]);

                    array_push($responses, $response->body());
                }
                else{
                    return $response->status();
                }

            }
            return $responses;
        }

    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $registros = Registro::where([
            ["lido_em", "=", null]
        ])->get();        

        if(count($registros)<=0){
            echo 'Vazio';
            $response = $this->enviar();
            print_r($response);
        }
        else{            
            $arquivoNome = 'arquivos/' . Carbon::now()->timestamp . '.json';
            Storage::put($arquivoNome,$registros);

            $arquivo = Storage::get($arquivoNome);

            $hash = md5($arquivo);
            
            Arquivo::create([
                'nome'      =>  $arquivoNome,
                'hash'      =>  $hash
            ]);
            
            foreach($registros as $registro){
                $registro->lido_em      =   Carbon::now();
                $registro->save();
            }
            $response = $this->enviar();
            print_r($response);

        }

        //return Command::SUCCESS;
    }
}

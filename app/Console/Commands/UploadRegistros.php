<?php

namespace App\Console\Commands;

use App\Models\Arquivo;
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
        $arquivos = Arquivo::where([
            ['enviado_em','=', null]
        ])->get();

        if(count($arquivos)<=0){
            echo "Sem arquivos para enviar";
        }
        else{
            foreach($arquivos as $arquivo){     
                
                $content = Storage::get($arquivo->nome);

                $response = Http::attach('arquivo', $content, $arquivo->nome)->post(env('API_URL'));

                if($response == $arquivo->hash){
                    $arquivo->enviado_em    = Carbon::now();
                    $arquivo->save();                    
                }
                else{
                    $response = null;
                }

                $upload = Upload::create([
                    'arquivo_id'    =>  $arquivo->id,
                    'response'      =>  $response                    
                ]);

            }
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
            $this->enviar();
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
            $this->enviar();

        }

        //return Command::SUCCESS;
    }
}

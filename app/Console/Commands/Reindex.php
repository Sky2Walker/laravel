<?php

namespace App\Console\Commands;

use App\Models\Product;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\returnArgument;

class Reindex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';
    protected $description = 'indexes all products';
    private $elasticsearch;
    private $items;

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->elasticsearch = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([
                'localhost:9200'
            ])
            ->build();
        $this->items = DB::table('products')->orderBy('id')->get();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing...');
        if($this->elasticsearch->indices()->exists(['index' => 'elastic_products'])) {
            try {
                $this->elasticsearch->indices()->delete(['index' => 'elastic_products']);
                $this->info('Index has been deleted');
            } catch (\Exception $e) {
                print_r($e->getMessage() . PHP_EOL);
            }

            //creating index
            try{
                $this->elasticsearch->indices()->create($this->params());
                $this->info('Index has been created');
            }catch(\Exception $e){
                print_r($e->getMessage() . PHP_EOL);
            }
        }else{
            try{
                $this->elasticsearch->indices()->create($this->params());
                $this->info('Index has been created');
            }catch(\Exception $e){
                print_r($e->getMessage() . PHP_EOL);
            }
        }

        // to Elastic
        foreach ($this->items as $k => $l) {
            $arEntryParams[$k] = $l;
        }
        foreach ($arEntryParams as $key => $item) {
            $params = [
                'index' => 'elastic_products',
                'type' => '_doc',
                'id' => $key + 1,
                'body' => $item
            ];

            try {
                $this->elasticsearch->index($params);

            } catch (\Exception $e) {
                print_r($e->getMessage() . PHP_EOL);
                exit;
            }
        }

        $this->info('\nDone');
    }


    private function params(){
        return [
            'index' => 'elastic_products',
            'body' =>[
                'settings'=>[
                    'analysis'=> [
                        'filter'=>[
                            "russian_stop" =>[
                                "type"=>"stop",
                                "stopwords"=>"_russian_",
                            ],
                            'shingle' =>[
                                'type' => 'shingle'
                            ],
                            'length_filter' =>[
                                'type' => 'length',
                                "min" => 3
                            ],
                            "russian_stemmer" =>[
                                "type"=>"stemmer",
                                "language"=>"russian",
                            ],
                            "english_stemmer" =>[
                                "type"=>"stemmer",
                                "language"=>"english",
                            ],
                        ],
                        'analyzer' => [
                            'rebuilt_russian'=> [
                                'type' => 'custom',
                                'tokenizer' =>'standard',
                                'filter' => [
                                    'lowercase',
                                    'length_filter',
                                    'trim',
                                    'russian_stemmer',
                                    'english_stemmer',
                                    'russian_stop',

                                ]
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    'properties' =>[
                        'id' =>[
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'text',
                            'analyzer' => 'rebuilt_russian'
                        ],
                        'description' =>[
                            'type' => 'text',
                            'analyzer' => 'rebuilt_russian'
                        ],


                    ]
                ]
            ]
        ];

    }

}

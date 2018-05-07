<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ClientCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:client';

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
     * @return mixed
     */
    public function handle()
    {
        $http = new Client();

        try {
            $response = $http->post('http://localhost:8000/oauth/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => '3',
                    'client_secret' => 'fWSn2MuCq3sIcN35bSe4Qq1fpreKi0ndKVS2rZh4',
                    'scope' => '*'
                ]
            ]);

            $result = json_decode((string) $response->getBody(), true);

            $this->info("\n\n");
            foreach ($result as $name => $value) {
                $this->info($name . " : " . $value . "\n");
            }

            // var_dump(json_decode((string) $response->getBody(), true));
        } catch (\Exception $e) {
            var_dump($e->getCode(), $e->getMessage());
        }
    }
}

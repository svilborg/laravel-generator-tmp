<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class RefreshCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:refresh
                            {t : Token}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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

        $rtoken = $this->argument("t");

        try {
            $response = $http->post('http://localhost:8000/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $rtoken,
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
        } catch (\Exception $e) {
            $this->error("Error : " . $e->getCode() . " : ");
            $this->warn($e->getMessage());
        }
    }
}

<?php

namespace App\Commands;

use OpenResourceManager\Client\Country as CountryClient;

class CountryDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:delete {id? : The country ID (optional)}
                            {--c|code= : The code of the country.}
                            ';

    /**
     * Hide this command
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a Country by it\'s ID, or code.';

    /**
     * AddressShowCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        parent::handle();

        $id = $this->argument('id');
        $code = $this->option('code');

        $client = new CountryClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($code)) {
                $this->error('No identifying information found. Provide an ID argument or code option.');
            } else {
                $response = $client->deleteFromCode($code);
            }
        } else {
            $response = $client->delete($id);
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

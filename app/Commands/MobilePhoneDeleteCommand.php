<?php

namespace App\Commands;

use OpenResourceManager\Client\MobilePhone as MobilePhoneClient;

class MobilePhoneDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobile:delete {id? : The mobile phone ID (optional)}
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
    protected $description = 'Deletes a Mobile Phone by it\'s ID.';

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

        $client = new MobilePhoneClient($this->orm);
        $response = null;

        if (empty($id)) {
            $this->error('No identifying information found. Provide an ID argument.');
        }

        $response = $client->delete($id);

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

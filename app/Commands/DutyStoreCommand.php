<?php

namespace App\Commands;

use openresourcemanager\client\Duty as DutyClient;

class DutyStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duty:store
                            {code : Unique code for the duty. Must be unique across all duty.}
                            {label : The duty label, this should be user friendly and easy to read.}
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
    protected $description = 'Store Duty information. Creates, updates, restores, a duty based on it\'s current status.';

    /**
     * AccountStoreCommand constructor.
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

        $response = null;

        $code = $this->argument('code');
        $label = $this->argument('label');

        $client = new DutyClient($this->orm);

        $response = $client->store($code, $label);

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

<?php

namespace App\Commands;

use openresourcemanager\client\MobileCarrier as MobileCarrierClient;

class MobileCarrierStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carrier:store
                            {code : Unique code for the mobile carrier. Must be unique across all mobile carriers.}
                            {label : The mobile carrier label, this should be user friendly and easy to read.}
                            {--i|country-id : The id of a country that this mobile carrier operates in. This is required without the country-code option.}
                            {--c|country-code : The code of a country that this mobile carrier operates in. This is required without the country-id option.}
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
    protected $description = 'Store Mobile Carrier information. Creates, updates, restores, a mobile carrier based on it\'s current status.';

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
        $countryID = $this->option('country-id');
        $countryCode = $this->option('country-code');

        if (empty($departmentCode) && empty($departmentID)) {
            $this->error('Provide a country-id option or country-code option.');
            die();
        }

        $client = new MobileCarrierClient($this->orm);

        $response = $client->store($code, $label, $countryID, $countryCode);

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

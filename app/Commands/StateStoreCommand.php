<?php

namespace App\Commands;

use openresourcemanager\client\State as StateClient;

class StateStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'state:store
                            {code : Unique code that identifies a state.}
                            {label : A label assigned to this state.}
                            {--country-id= : The id of the parent country. This is required without the --country-code option.}
                            {--country-code= : The code of the parent country. This is required without the --country-id option. }
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
    protected $description = 'Store State information. Creates, updates, restores, a state based on it\'s current status.';

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

        if (empty($countryID) && empty($countryCode)) {
            $this->error('Provide a country-id option or country-code option');
            die();
        }

        $client = new StateClient($this->orm);

        $response = $client->store(
            $code,
            $label,
            $countryID,
            $countryCode
        );
        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

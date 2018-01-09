<?php

namespace App\Commands;

use openresourcemanager\client\Building as BuildingClient;

class BuildingStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'building:store
                            {code : Unique code for the building. Must be unique across all buildings.}
                            {label : The building label, this should be user friendly and easy to read.}
                            {--campus-id= : The id of the parent campus. This is required without the --campus-code argument.}
                            {--campus-code= : The code of the parent campus. This is required without the --campus-id argument. }
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
    protected $description = 'Store Building information. Creates, updates, restores, a building based on it\'s current status.';

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
        $campusID = $this->option('campus-id');
        $campusCode = $this->option('campus-code');
        if (empty($campusCode) && empty($campusID)) {
            $this->error('Provide a campus-id or campus-code');
            die();
        }
        $buildingClient = new BuildingClient($this->orm);
        $response = $buildingClient->store($code, $label, $campusID, $campusCode);
        // Cache the current ORM object
        $this->cacheORM($buildingClient->getORM());
        $this->displayResponseBody($response);
    }
}

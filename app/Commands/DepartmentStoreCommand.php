<?php

namespace App\Commands;

use openresourcemanager\client\Department as DepartmentClient;

class DepartmentStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'department:store
                            {code : Unique code for the department. Must be unique across all departments.}
                            {label : The department label, this should be user friendly and easy to read.}
                            {--academic : Is the department academic? If so it can have courses.}
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
    protected $description = 'Store Department information. Creates, updates, restores, a department based on it\'s current status.';

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
        $academic = $this->option('academic');

        $client = new DepartmentClient($this->orm);

        $response = $client->store($code, $label, $academic);

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

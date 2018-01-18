<?php

namespace App\Commands;

use openresourcemanager\client\School as SchoolClient;

class SchoolDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:delete
                            {id? : Unique primary key for school. This is required without the code option.}
                            {--c|code= : Unique code that identifies a school. This is required without the id option.}
                            
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
    protected $description = 'Deletes a School by it\'s ID, or code.';

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

        $id = $this->argument('id');
        $code = $this->option('code');

        $client = new SchoolClient($this->orm);
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

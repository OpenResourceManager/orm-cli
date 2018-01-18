<?php

namespace App\Commands;


use OpenResourceManager\Client\ServiceAccount as ServiceClient;

class ServiceAccountDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-account:delete {id? : The alias account ID (optional)}
                            {--i|identifier= : The identifier of the alias account.}
                            {--u|username= : The username of the alias account.}
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
    protected $description = 'Deletes an Alias Account by it\'s ID, or username.';

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
        $identifier = $this->option('identifier');
        $username = $this->option('username');

        $client = new ServiceClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($username) && empty($identifier)) {
                $this->error('No identifying information found. Provide an ID argument or username option.');
            } else if (!empty($username)) {
                $response = $client->deleteFromUsername($username);
            } else if (!empty($id)) {
                $response = $client->deleteFromIdentifier($identifier);
            }
        } else {
            $response = $client->delete($id);
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

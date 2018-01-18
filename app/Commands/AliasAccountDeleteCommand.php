<?php

namespace App\Commands;


use OpenResourceManager\Client\AliasAccount as AliasClient;

class AliasAccountDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alias-account:delete {id? : The alias account ID (optional)}
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
        $username = $this->option('username');

        $client = new AliasClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($username)) {
                $this->error('No identifying information found. Provide an ID argument or username option.');
            } else {
                $response = $client->deleteFromUsername($username);
            }
        } else {
            $response = $client->delete($id);
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

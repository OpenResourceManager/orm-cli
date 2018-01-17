<?php

namespace App\Commands;

use OpenResourceManager\Client\Email as EmailClient;

class EmailDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:delete {id? : The email ID (optional)}
                            {--a|address= : The address of the email.}
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
    protected $description = 'Deletes an Email by it\'s ID, or address.';

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
        $address = $this->option('address');

        $client = new EmailClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($address)) {
                $this->error('No identifying information found. Provide an ID argument or address option.');
            } else {
                $response = $client->deleteFromAddress($address);
            }
        } else {
            $response = $client->delete($id);
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

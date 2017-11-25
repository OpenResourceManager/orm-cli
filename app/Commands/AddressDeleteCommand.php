<?php

namespace App\Commands;

use OpenResourceManager\Client\Addresses as AddressClient;

class AddressDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:delete {id : The Address ID}
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
    protected $description = 'Delete an Address by it\'s id.';

    /**
     * AccountDeleteCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        parent::handle();

        $id = $this->argument('id');

        $addressClient = new AddressClient($this->orm);

        $response = $addressClient->delete($id);

        $this->displayResponseCode($response);
    }
}

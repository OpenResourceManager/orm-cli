<?php

namespace App\Commands;


use Carbon\Carbon;
use OpenResourceManager\Client\Addresses as AddressClient;

class AddressStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:store
                            {addressee : The name of the person to address at this address}
                            {line-1 : The first line in the address}
                            {city : The city that this address is located in}
                            {zip : The zip code that this address resides in}
                            {--a|account-id= : Account ID of the address owner}
                            {--i|identifier= : Identifier of the address owner}
                            {--u|username= : Username of the address owner}
                            {--organization= : The organization located at this address, if any}
                            {--line-2 : The second line in the address, if any}
                            {--state-id : The primary key of the state that this address resides in. This is required without the state-code parameter}
                            {--state-code : The unique code of the state that this address resides in. This is required without the state-id parameter}
                            {--country-id : The primary key of the country that this address resides in. This is required without the country-code parameter}
                            {--country-code : The unique code of the country that this address resides in. This is required without the country-id parameter}
                            {--latitude : A latitude value related to this address, if any}
                            {--longitude : A longitude value related to this address, if any}
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
    protected $description = 'Store an address. Creates, updates, restores, an address based on it\'s current status.';

    /**
     * AddressStoreCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        $response = null;

        $addressClient = new AddressClient($this->orm);

        $response = $addressClient->store(
            $this->option('account-id'),
            $this->option('identifier'),
            $this->option('username'),
            $this->argument('addressee'),
            $this->option('organization'),
            $this->argument('line-1'),
            $this->option('line-2'),
            $this->argument('city'),
            $this->option('state-id'),
            $this->option('state-code'),
            $this->argument('zip'),
            $this->option('country-id'),
            $this->option('country-code'),
            $this->option('latitude'),
            $this->option('longitude')
        );

        // Cache the current ORM object
        $this->cacheORM($addressClient->getORM());
        $this->displayResponseBody($response);
    }
}

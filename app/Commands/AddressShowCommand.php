<?php

namespace App\Commands;


use OpenResourceManager\Client\Addresses as AddressClient;

class AddressShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:show {id? : The address ID (optional)}
                            {--a|account-id= : The account ID of the address owner, all addresses owned by this account are displayed}
                            {--i|identifier= : The identifier of the address owner, all addresses owned by this account are displayed}
                            {--u|username= : The username of the address owner, all addresses owned by this account are displayed}
                            {--p|page= : The page of results to display}
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
    protected $description = 'Show an Address by it\'s ID, account ID, identifier, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.';

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
     */
    public function handle(): void
    {
        parent::handle();

        $id = $this->argument('id');

        $accountID = $this->option('account-id');
        $identifier = $this->option('identifier');
        $username = $this->option('username');
        $page = $this->option('page');

        $addressClient = new AddressClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($identifier) && empty($username) && empty($accountID)) {
                if (!empty($page)) {
                    $addressClient->setPage($page);
                }
                $response = $addressClient->getList();
            } elseif (!empty($accountID)) {
                $response = $addressClient->getForAccount($accountID);
            } elseif (!empty($identifier)) {
                $response = $addressClient->getForIdentifier($identifier);
            } elseif (!empty($username)) {
                $response = $addressClient->getForUsername($username);
            }
        } else {
            $response = $addressClient->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($addressClient->getORM());
        $this->displayResponseBody($response);
    }
}

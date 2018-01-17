<?php

namespace App\Commands;


use OpenResourceManager\Client\MobilePhone as MobilePhoneClient;

class MobilePhoneShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobile:show {id? : The mobile phone ID (optional)}
                            {--a|account-id= : The show mobile phones attached to an account by providing the account ID.}
                            {--i|identifier= : The show mobile phones attached to an account by providing the account identifier.}
                            {--u|username= : The show mobile phones attached to an account by providing the account username.}
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
    protected $description = 'Show a Mobile Phone by it\'s ID. Displays a paginated list when those parameters are omitted, a page parameter is available.';

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
        $page = $this->option('page');
        $accountID = $this->option('account-id');
        $identifier = $this->option('identifier');
        $username = $this->option('username');

        $client = new MobilePhoneClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($identifier) && empty($username) && empty($accountID)) {
                if (!empty($page)) {
                    $client->setPage($page);
                }
                $response = $client->getList();
            } elseif (!empty($accountID)) {
                $response = $client->getForAccount($accountID);
            } elseif (!empty($identifier)) {
                $response = $client->getForIdentifier($identifier);
            } elseif (!empty($username)) {
                $response = $client->getForUsername($username);
            }
        } else {
            $response = $client->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

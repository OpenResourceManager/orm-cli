<?php

namespace App\Commands;


use OpenResourceManager\Client\Account as AccountClient;

class AccountShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:show {id? : The Account ID (optional)}
                            {--i|identifier= : The identifier of the account to display}
                            {--u|username= : The username of the account to display}
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
    protected $description = 'Show an ORM Account by it\'s ID, identifier, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.';

    /**
     * AccountShowCommand constructor.
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
        $page = $this->option('page');

        $accountClient = new AccountClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($identifier) && empty($username)) {
                if (!empty($page)) {
                    $accountClient->setPage($page);
                }
                $response = $accountClient->getList();
            } elseif (!empty($identifier)) {
                $response = $accountClient->getFromIdentifier($identifier);
            } elseif (!empty($username)) {
                $response = $accountClient->getFromUsername($username);
            }
        } else {
            $response = $accountClient->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($accountClient->getORM());
        $this->displayResponseBody($response);
    }
}

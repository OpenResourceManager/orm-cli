<?php

namespace App\Commands;


use OpenResourceManager\Client\ServiceAccount as ServiceClient;

class ServiceAccountShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-account:show {id? : The service account ID (optional)}
                            {--i|identifier= : The identifier of the service account.}
                            {--u|username= : The username of the service account.}
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
    protected $description = 'Show a Service Account by it\'s ID, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.';

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
        $page = $this->option('page');

        $client = new ServiceClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($username) && empty($identifier)) {
                if (!empty($page)) {
                    $client->setPage($page);
                }
                $response = $client->getList();
            } elseif (!empty($username)) {
                $response = $client->getFromUsername($username);
            } elseif (!empty($identifier)) {
                $response = $client->deleteFromIdentifier($identifier);
            }
        } else {
            $response = $client->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

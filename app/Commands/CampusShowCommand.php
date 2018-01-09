<?php

namespace App\Commands;

use OpenResourceManager\Client\Campus as CampusClient;

class CampusShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campus:show {id? : The campus ID (optional)}
                            {--c|code= : The code of the campus.}
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
    protected $description = 'Show a Campus by it\'s ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.';

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
        $code = $this->option('code');
        $page = $this->option('page');

        $campusClient = new CampusClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($code)) {
                if (!empty($page)) {
                    $campusClient->setPage($page);
                }
                $response = $campusClient->getList();
            } elseif (!empty($code)) {
                $response = $campusClient->getFromCode($code);
            }
        } else {
            $response = $campusClient->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($campusClient->getORM());
        $this->displayResponseBody($response);
    }
}

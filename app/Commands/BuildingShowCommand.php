<?php

namespace App\Commands;


use OpenResourceManager\Client\Building as BuildingClient;

class BuildingShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'building:show {id? : The building ID (optional)}
                            {--c|code= : The code of the building.}
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
    protected $description = 'Show an Building by it\'s ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.';

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

        $aliasClient = new BuildingClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($code)) {
                if (!empty($page)) {
                    $aliasClient->setPage($page);
                }
                $response = $aliasClient->getList();
            } elseif (!empty($code)) {
                $response = $aliasClient->getFrom($code);
            }
        } else {
            $response = $aliasClient->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($aliasClient->getORM());
        $this->displayResponseBody($response);
    }
}
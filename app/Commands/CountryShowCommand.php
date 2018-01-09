<?php

namespace App\Commands;


use OpenResourceManager\Client\Country as CountryClient;

class CountryShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:show {id? : The country ID (optional)}
                            {--c|code= : The code of the country.}
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
    protected $description = 'Show a Country by it\'s ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.';

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

        $countryClient = new CountryClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($code)) {
                if (!empty($page)) {
                    $countryClient->setPage($page);
                }
                $response = $countryClient->getList();
            } elseif (!empty($code)) {
                $response = $countryClient->getFromCode($code);
            }
        } else {
            $response = $countryClient->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($countryClient->getORM());
        $this->displayResponseBody($response);
    }
}

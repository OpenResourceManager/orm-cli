<?php

namespace App\Commands;


use OpenResourceManager\Client\Course as CourseClient;

class CourseShowCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:show {id? : The course ID (optional)}
                            {--c|code= : The code of the course.}
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
    protected $description = 'Show a Course by it\'s ID, or code. Displays a paginated list when those parameters are omitted, a page parameter is available.';

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

        $client = new CourseClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($code)) {
                if (!empty($page)) {
                    $client->setPage($page);
                }
                $response = $client->getList();
            } elseif (!empty($code)) {
                $response = $client->getFromCode($code);
            }
        } else {
            $response = $client->get($id);
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

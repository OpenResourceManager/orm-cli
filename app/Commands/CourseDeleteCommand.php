<?php

namespace App\Commands;

use OpenResourceManager\Client\Course as CourseClient;

class CourseDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:delete {id? : The course ID (optional)}
                            {--c|code= : The code of the course.}
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
    protected $description = 'Deletes a Course by it\'s ID, or code.';

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

        $courseClient = new CourseClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($code)) {
                $this->error('No identifying information found. Provide an ID or code.');
            } else {
                $response = $courseClient->deleteFromCode($code);
            }
        } else {
            $response = $courseClient->delete($id);
        }

        // Cache the current ORM object
        $this->cacheORM($courseClient->getORM());
        $this->displayResponseBody($response);
    }
}

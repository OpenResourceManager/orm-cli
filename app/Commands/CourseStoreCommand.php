<?php

namespace App\Commands;

use openresourcemanager\client\Course as CourseClient;

class CourseStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:store
                            {code : Unique code for the course. Must be unique across all courses.}
                            {label : The course label, this should be user friendly and easy to read.}
                            {course-level : The academic level of this course.}
                            {--department-id : The id of the parent department. This is required without the --department-code attribute.}
                            {--department-code : The unique code of the parent department. This is required without the --department-id attribute.}
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
    protected $description = 'Store Course information. Creates, updates, restores, a course based on it\'s current status.';

    /**
     * AccountStoreCommand constructor.
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

        $response = null;

        $code = $this->argument('code');
        $label = $this->argument('label');
        $level = $this->argument('course-level');
        $departmentID = $this->option('department-id');
        $departmentCode = $this->option('department-code');
        if (empty($departmentCode) && empty($departmentID)) {
            $this->error('Provide a department-id option or department-code option.');
            die();
        }
        $client = new CourseClient($this->orm);

        $response = $client->store($code, $label, $level, $departmentID, $departmentCode);

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

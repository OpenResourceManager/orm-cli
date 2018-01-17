<?php

namespace App\Commands;

use OpenResourceManager\Client\Account as AccountClient;

class AccountAttachCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:attach {id? : The Account ID (optional)}
                            {--i|identifier= : The identifier of the account}
                            {--u|username= : The username of the account}
                            {--duty-id= : The ID of the duty to attach to}
                            {--duty-code= : The code of the duty to attach to}
                            {--course-id= : The ID of the course to attach to}
                            {--course-code= : The code of the course to attach to}
                            {--school-id= : The ID of the school to attach to}
                            {--school-code= : The code of the school to attach to}
                            {--department-id= : The ID of the department to attach to}
                            {--department-code= : The code of the department to attach to}
                            {--room-id= : The ID of the room to attach to}
                            {--room-code= : The code of the room to attach to}
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
    protected $description = 'Attach an ORM Account by it\'s id, identifier, or username to a duty, course, school, department, or room by their ID or code.';

    /**
     * AccountAttachCommand constructor.
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

        $id = (!empty($this->argument('id'))) ? $this->argument('id') : null;
        $identifier = (!empty($this->option('identifier'))) ? $this->option('identifier') : null;
        $username = (!empty($this->option('username'))) ? $this->option('username') : null;

        $dutyID = $this->option('duty-id');
        $dutyCode = $this->option('duty-code');
        $courseID = $this->option('course-id');
        $courseCode = $this->option('course-code');
        $schoolID = $this->option('school-id');
        $schoolCode = $this->option('school-code');
        $departmentID = $this->option('department-id');
        $departmentCode = $this->option('department-code');
        $roomID = $this->option('room-id');
        $roomCode = $this->option('room-code');

        $responses = [];

        if (empty($id) && empty($identifier) && empty($username)) {
            $this->error('Provide an id argument, identifier option, or username option to associate.');
            die();
        }

        $client = new AccountClient($this->orm);

        if (!is_null($dutyID)) {
            $r = $client->attachToDuty($id, $identifier, $username, $dutyID, null);
            $responses['duty-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($dutyCode)) {
            $r = $client->attachToDuty($id, $identifier, $username, null, $dutyCode);
            $responses['duty-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($courseID)) {
            $r = $client->attachToCourse($id, $identifier, $username, $courseID, null);
            $responses['course-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($courseCode)) {
            $r = $client->attachToCourse($id, $identifier, $username, null, $courseCode);
            $responses['course-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($schoolID)) {
            $r = $client->attachToSchool($id, $identifier, $username, $schoolID, null);
            $responses['school-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($schoolCode)) {
            $r = $client->attachToSchool($id, $identifier, $username, null, $schoolCode);
            $responses['school-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($departmentID)) {
            $r = $client->attachToDepartment($id, $identifier, $username, $departmentID, null);
            $responses['department-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($departmentCode)) {
            $r = $client->attachToDepartment($id, $identifier, $username, null, $departmentCode);
            $responses['department-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($roomID)) {
            $r = $client->attachToRoom($id, $identifier, $username, $roomID, null);
            $responses['room-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($roomCode)) {
            $r = $client->attachToRoom($id, $identifier, $username, null, $roomCode);
            $responses['room-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayData($responses);
    }
}

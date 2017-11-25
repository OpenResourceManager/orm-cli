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
     * AccountDeleteCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
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

        $accountClient = new AccountClient($this->orm);


        if (!is_null($dutyID)) {
            $r = $accountClient->attachToDuty($id, $identifier, $username, $dutyID, null);
            $responses['duty-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($dutyCode)) {
            $r = $accountClient->attachToDuty($id, $identifier, $username, null, $dutyCode);
            $responses['duty-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($courseID)) {
            $r = $accountClient->attachToCourse($id, $identifier, $username, $courseID, null);
            $responses['course-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($courseCode)) {
            $r = $accountClient->attachToCourse($id, $identifier, $username, null, $courseCode);
            $responses['course-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($schoolID)) {
            $r = $accountClient->attachToSchool($id, $identifier, $username, $schoolID, null);
            $responses['school-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($schoolCode)) {
            $r = $accountClient->attachToSchool($id, $identifier, $username, null, $schoolCode);
            $responses['school-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($departmentID)) {
            $r = $accountClient->attachToDepartment($id, $identifier, $username, $departmentID, null);
            $responses['department-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($departmentCode)) {
            $r = $accountClient->attachToDepartment($id, $identifier, $username, null, $departmentCode);
            $responses['department-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($roomID)) {
            $r = $accountClient->attachToRoom($id, $identifier, $username, $roomID, null);
            $responses['room-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($roomCode)) {
            $r = $accountClient->attachToRoom($id, $identifier, $username, null, $roomCode);
            $responses['room-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        $this->displayData($responses);
    }
}

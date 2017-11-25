<?php

namespace App\Commands;

use OpenResourceManager\Client\Account as AccountClient;

class AccountDetachCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:detach {id? : The Account ID (optional)}
                            {--i|identifier= : The identifier of the account}
                            {--u|username= : The username of the account}
                            {--duty-id= : The ID of the duty to detach from}
                            {--duty-code= : The code of the duty to detach from}
                            {--course-id= : The ID of the course to detach from}
                            {--course-code= : The code of the course to detach from}
                            {--school-id= : The ID of the school to detach from}
                            {--school-code= : The code of the school to detach from}
                            {--department-id= : The ID of the department to detach from}
                            {--department-code= : The code of the department to detach from}
                            {--room-id= : The ID of the room to detach from}
                            {--room-code= : The code of the room to detach from}
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
    protected $description = 'Detach an ORM Account by it\'s id, identifier, or username to a duty, course, school, department, or room by their ID or code.';

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
            $r = $accountClient->detachFromDuty($id, $identifier, $username, $dutyID, null);
            $responses['duty-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($dutyCode)) {
            $r = $accountClient->detachFromDuty($id, $identifier, $username, null, $dutyCode);
            $responses['duty-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($courseID)) {
            $r = $accountClient->detachFromCourse($id, $identifier, $username, $courseID, null);
            $responses['course-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($courseCode)) {
            $r = $accountClient->detachFromCourse($id, $identifier, $username, null, $courseCode);
            $responses['course-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($schoolID)) {
            $r = $accountClient->detachFromSchool($id, $identifier, $username, $schoolID, null);
            $responses['school-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($schoolCode)) {
            $r = $accountClient->detachFromSchool($id, $identifier, $username, null, $schoolCode);
            $responses['school-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($departmentID)) {
            $r = $accountClient->detachFromDepartment($id, $identifier, $username, $departmentID, null);
            $responses['department-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($departmentCode)) {
            $r = $accountClient->detachFromDepartment($id, $identifier, $username, null, $departmentCode);
            $responses['department-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($roomID)) {
            $r = $accountClient->detachFromRoom($id, $identifier, $username, $roomID, null);
            $responses['room-id'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        if (!is_null($roomCode)) {
            $r = $accountClient->detachFromRoom($id, $identifier, $username, null, $roomCode);
            $responses['room-code'] = [
                'response-code' => $r->code,
                'response-body' => $r->body
            ];
        }

        $this->displayData($responses);
    }
}

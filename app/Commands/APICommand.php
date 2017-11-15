<?php

namespace App\Commands;

use OpenResourceManager\ORM;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class APICommand extends ProfileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * The ORM API object
     *
     * @var ORM
     */
    protected $orm;

    /**
     * ORM Session Data
     *
     * @var array
     */
    protected $session_data = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function initORM()
    {
        $profile = $this->getActiveProfile();
        $data = [];
        if ($profile) {
            $data['profile_id'] = $profile->id;
            // Try to get a previous session
            $session = DB::select('select * from orm_sessions where profile_id = ?', [$profile->id]);
            if ($session) {
                $data['session_id'] = $session[0]->id;
                // If we have a previous session get it
                $orm = unserialize($session[0]->orm);
            } else {
                $data['session_id'] = null;
                // If not create a new one
                $orm = new ORM($profile->secret, $profile->host, $profile->version, $profile->port, $profile->use_ssl);
            }
            $data['orm'] = $orm;
            $this->orm = $orm;
            $this->session_data = $data;
            return $data;
        } else {
            $this->error('No active ORM profiles found. Create one.');
            die();
        }
    }

    public function storeORM()
    {
        $now = Carbon::now('UTC')->toDateTimeString();
        $orm = $this->orm;
        $session_id = $this->session_data['session_id'];
        $profile_id = $this->session_data['profile_id'];

        if (!empty($session_id)) {
            DB::update('update orm_sessions set orm = ?, updated_at = ? where id = ?', [serialize($orm), $now, $session_id]);
        } else if (!empty($profile_id)) {
            DB::table('orm_sessions')->insert(
                [
                    'orm' => serialize($orm),
                    'profile_id' => $profile_id,
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            );
        } else {
            $this->error('Failed to store session, missing profile id!');
            die();
        }
    }

    /**
     * Displays the entire API response
     *
     * @param $response
     * @throws Exception
     */
    public function displayResponse($response)
    {
        // Hold onto our ORM session
        $this->storeORM();
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode($response, JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            throw new Exception($response->body->message, $response->code);
        }
    }

    /**
     * Displays the API response body
     *
     * @param $response
     * @throws Exception
     */
    public function displayResponseBody($response)
    {
        // Hold onto our ORM session
        $this->storeORM();
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode($response->body, JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            throw new Exception($response->body->message, $response->code);
        }
    }

    /**
     * Displays the API response data
     *
     * @param $response
     * @throws Exception
     */
    public function displayResponseData($response)
    {
        // Hold onto our ORM session
        $this->storeORM();
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode($response->body->data, JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            throw new Exception($response->body->message, $response->code);
        }
    }

    /**
     * Displays the API response code
     *
     * @param $response
     * @throws Exception
     */
    public function displayResponseCode($response)
    {
        // Hold onto our ORM session
        $this->storeORM();
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode((object)['code' => $response->code], JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            throw new Exception($response->body->message, $response->code);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->initORM();
        $this->storeORM();
    }
}

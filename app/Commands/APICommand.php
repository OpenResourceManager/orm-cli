<?php

namespace App\Commands;

use OpenResourceManager\ORM;
use Illuminate\Support\Facades\Cache;
use Exception;

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
     * The current profile
     *
     * @var
     */
    protected $profile;

    /**
     * @var string
     */
    protected $sessionKey;

    /**
     * APICommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Displays the entire API response
     *
     * @param $response
     * @throws Exception
     * @return void
     */
    public function displayResponse($response): void
    {
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
     * Displays raw data
     *
     * @param $data
     * @return void
     */
    public function displayData($data): void
    {
        // Format some nice JSON
        $json = json_encode($data, JSON_PRETTY_PRINT);
        // Print the json
        $this->info($json);
    }

    /**
     * Displays the API response body
     *
     * @param $response
     * @throws Exception
     * @return void
     */
    public function displayResponseBody($response): void
    {
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
     * @return void
     */
    public function displayResponseData($response): void
    {
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
     * @return void
     */
    public function displayResponseCode($response): void
    {
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
     * Cache ORM object
     *
     * Stores an ORM object in the cache
     *
     * @param $orm
     * @return void
     */
    public function cacheORM($orm): void
    {
        if (empty($this->orm)) {
            Cache::put($this->sessionKey, serialize($orm), $this->profile->ttl);
        } else if ($orm->jwt !== $this->orm->jwt) {
            Cache::put($this->sessionKey, serialize($orm), $this->profile->ttl);
        }
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Get the active profile
        $mProfile = $this->getActiveProfile();
        if ($mProfile) {
            // Build the session key
            $mSessionKey = 'orm_session_' . $mProfile->id;
            // Get any cached sessions
            $mSession = Cache::get($mSessionKey);

            // Store the profile and sessions key
            $this->profile = $mProfile;
            $this->sessionKey = $mSessionKey;

            // If we have a session
            if (!empty($mSession)) {
                // Unserialize the ORM session data
                $mORM = unserialize($mSession);
            } else {
                // Create a new session since we did not
                $mORM = new ORM(
                    $mProfile->secret,
                    $mProfile->host,
                    $mProfile->version,
                    $mProfile->port,
                    $mProfile->use_ssl
                );
                // Cache it for later
                $this->cacheORM($mORM);
            }

            // Store the orm session on this object
            $this->orm = $mORM;

        } else {
            // No active profile found!
            $this->error('No active ORM profiles found. Create one.');
            die();
        }
    }
}

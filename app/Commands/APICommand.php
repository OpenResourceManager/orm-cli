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
     * @return integer
     */
    public function displayResponse($response): int
    {
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode($response, JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
            return 0;
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            $this->error($response->body->message);
            return intval($response->code);
        }
    }

    /**
     * Displays raw data
     *
     * @param $data
     * @return integer
     */
    public function displayData($data): int
    {
        // Format some nice JSON
        $json = json_encode($data, JSON_PRETTY_PRINT);
        // Print the json
        $this->info($json);
        return 0;
    }

    /**
     * Displays the API response body
     *
     * @param $response
     * @return integer
     */
    public function displayResponseBody($response): int
    {
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode($response->body, JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
            return 0;
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            $this->error($response->body->message);
            return intval($response->code);
        }
    }

    /**
     * Displays the API response data
     *
     * @param $response
     * @return integer
     */
    public function displayResponseData($response): int
    {
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode($response->body->data, JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
            return 0;
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            $this->error($response->body->message);
            return intval($response->code);
        }
    }

    /**
     * Displays the API response code
     *
     * @param $response
     * @return integer
     */
    public function displayResponseCode($response): int
    {
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Format some nice JSON
            $json = json_encode((object)['code' => $response->code], JSON_PRETTY_PRINT);
            // Print the json
            $this->info($json);
            return 0;
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            $json = json_encode((object)['code' => $response->code], JSON_PRETTY_PRINT);
            $this->error($json);
            return intval($response->code);
        }
    }

    /**
     * Displays a textual representation of the account status
     *
     * @param $response
     * @return integer
     */
    public function displayCheckResult($response): int
    {
        // Verify that the API returned a 200 http code
        if (in_array($response->code, VALID_CODES, true)) {
            // Print the json
            $this->info("Account is valid!");
            return 0;
        } else {
            // Throw an exception if we did not get 200 back
            // display the http code with the message from the API.
            $this->error($response->body->message);
            return intval($response->code);
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
        $sessionTTL = (intval($orm->authResponse->headers['x-jwt-ttl']) - 1);
        if ($sessionTTL < 1) $sessionTTL = 1;

        if (empty($this->orm)) {
            Cache::put($this->sessionKey, serialize($orm), $sessionTTL);
        } else if ($orm->jwt !== $this->orm->jwt) {
            Cache::put($this->sessionKey, serialize($orm), $sessionTTL);
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

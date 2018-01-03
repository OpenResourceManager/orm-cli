<?php

namespace App\Commands;

use OpenResourceManager\Client\Account as AccountClient;

class AccountDeleteCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:delete {id? : The Account ID (optional)}
                            {--i|identifier= : The identifier of the account to delete}
                            {--u|username= : The username of the account to delete}
                            {--j|json-file= : A json file for batch deletions identifier. Takes precedence over all other options and arguments}
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
    protected $description = 'Delete an ORM Account by it\'s id, identifier, or username.';

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
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        parent::handle();

        $id = $this->argument('id');
        $identifier = $this->option('identifier');
        $username = $this->option('username');
        $jsonFile = $this->option('json-file');

        $accountClient = new AccountClient($this->orm);

        if (empty($jsonFile)) {
                $response = null;
                if (empty($id)) {
                    if (empty($identifier) && empty($username)) {
                        $this->error('No identifying information found. Provide an ID, identifier, or username.');
                    } elseif (!empty($identifier)) {
                        $response = $accountClient->deleteFromIdentifier($identifier);
                    } elseif (!empty($username)) {
                        $response = $accountClient->deleteFromUsername($username);
                    }
                } else {
                    $response = $accountClient->delete($id);
                }

                $this->displayResponseCode($response);
        } else {
            // json file stuff
            $identifiers = json_decode(file_get_contents($jsonFile));
            $data = [];
            foreach ($identifiers as $i) {
                $i = trim($i, " \t\n\r\0\x0B,");
                if (!empty($i)) {
                    // delete the identifier
                    $response = $accountClient->deleteFromIdentifier($i);
                    // store the identifier in an array under the response code
                    $data[$response->code][] = $i;
                    // sleep a bit to avoid spamming the API
                    usleep(125000);
                }
            }
            // Cache the current ORM object
            $this->cacheORM($accountClient->getORM());
            $this->displayData($data);
        }
    }
}

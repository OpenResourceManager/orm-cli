<?php

namespace App\Commands;


use OpenResourceManager\Client\Account as AccountClient;

class AccountCheckCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:check {id? : The Account ID (optional)}
                            {--i|identifier= : The identifier of the account to display}
                            {--u|username= : The username of the account to display}
                            {--j|json-file= : A json file or identifiers or username. Use the use-identifier or use-username options to chose the type.}
                            {--use-username : Signifies that usernames are in the json file.}
                            {--use-identifier : Signifies that identifiers are in the json file.}
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
    protected $description = 'Show an ORM Account by it\'s ID, identifier, or username. Displays a paginated list when those parameters are omitted, a page parameter is available.';

    /**
     * AccountShowCommand constructor.
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
        $useUsername = $this->option('use-username');
        $useIdentifier = $this->option('use-identifier');

        $client = new AccountClient($this->orm);

        if (empty($jsonFile)) {
            $response = null;
            if (empty($id)) {
                if (empty($identifier) && empty($username)) {
                } elseif (!empty($identifier)) {
                    $response = $client->getFromIdentifier($identifier);
                } elseif (!empty($username)) {
                    $response = $client->getFromUsername($username);
                }
            } else {
                $response = $client->get($id);
            }
            // Cache the current ORM object
            $this->cacheORM($client->getORM());
            $this->displayCheckResult($response);
        } else {
            $info = json_decode(file_get_contents($jsonFile));
            $data = [];
            foreach ($info as $i) {
                $i = trim($i, " \t\n\r\0\x0B,");
                if (!empty($i)) {
                    if ($useIdentifier) {
                        $response = $client->getFromIdentifier($i);
                    } elseif ($useUsername) {
                        $response = $client->getFromUsername($i);
                    }
                    $data[$response->code][] = $i;
                    usleep(125000);
                }
            }
            // Cache the current ORM object
            $this->cacheORM($client->getORM());
            $this->displayData($data);
        }
    }
}

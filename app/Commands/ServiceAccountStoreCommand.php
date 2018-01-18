<?php

namespace App\Commands;


use Carbon\Carbon;
use OpenResourceManager\Client\ServiceAccount as ServiceClient;

class ServiceAccountStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-account:store
                            {identifier : Unique identifier for account. Must be unique across all accounts and service accounts}
                            {username : Unique username for account. Must be unique across all accounts, alias accounts, and service accounts}
                            {name-first : The first name of the service}
                            {name-last : The last name of the service}
                            {--o|owner-id= : The service account owner ID. This is required without --owner-identifier / --owner-username}
                            {--i|owner-identifier= : The service account owner identifier. This is required without --owner-id / --owner-username}
                            {--u|owner-username= : The service account owner username. This is required without --owner-id / --owner-identifier}
                            {--p|password= : The initial password assigned to this account when it is created. This is only available to API consumers who have classified permissions}
                            {--s|should-propagate-password : If this is set and a password parameter is supplied third party integrations such as Active Directory will use this password for the account within their systems}
                            {--e|expires-at= : The account\'s expiration date in string format(yyyy-mm-dd hh:mm) or (yyyy-mm-dd)}
                            {--d|disabled : Determines if this account is disabled}
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
    protected $description = 'Store Service Account information. Creates, updates, restores, a service account based on it\'s current status.';

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

        $username = $this->argument('username');
        $identifier = $this->argument('identifier');
        $firstName = $this->argument('name-first');
        $lastName = $this->argument('name-last');
        $ownerID = $this->option('alias-owner-id');
        $ownerIdentifier = $this->option('alias-owner-identifier');
        $ownerUsername = $this->option('alias-owner-username');
        if (empty($ownerIdentifier) && empty($ownerID) && empty($ownerUsername)) {
            $this->error('Provide an owner-id option, owner-identifier option, or owner-username option to associate.');
            die();
        }
        $password = $this->option('password');
        $shouldPropagatePassword = $this->option('should-propagate-password');
        $expiresAt = $this->option('expires-at');
        $disabled = $this->option('disabled');

        if (!empty($expiresAt)) $expiresAt = Carbon::parse($expiresAt)->timestamp;

        $client = new ServiceClient($this->orm);

        $response = $client->store(
            $identifier,
            $username,
            $firstName,
            $lastName,
            $shouldPropagatePassword,
            $password,
            $ownerID,
            $ownerIdentifier,
            $ownerUsername,
            $expiresAt,
            $disabled
        );

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

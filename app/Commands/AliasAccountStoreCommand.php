<?php

namespace App\Commands;


use Carbon\Carbon;
use OpenResourceManager\Client\AliasAccount as AliasClient;

class AliasAccountStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alias-account:store
                            {username : Unique username for account. Must be unique across all accounts, alias accounts, and service accounts}
                            {--o|owner-id= : The alias account owner ID. This is required without --owner-identifier / --owner-username}
                            {--i|owner-identifier= : The alias account owner identifier. This is required without --owner-id / --owner-username}
                            {--u|owner-username= : The alias account owner username. This is required without --owner-id / --owner-identifier}
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
    protected $description = 'Store Alias Account information. Creates, updates, restores, an alias account based on it\'s current status.';

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
        $aliasOwnerID = $this->option('owner-id');
        $aliasOwnerIdentifier = $this->option('owner-identifier');
        $aliasOwnerUsername = $this->option('owner-username');
        if (empty($aliasOwnerIdentifier) && empty($aliasOwnerID) && empty($aliasOwnerUsername)) {
            $this->error('Provide an owner-id option, owner-identifier option, or owner-username option to associate.');
            die();
        }
        $password = $this->option('password');
        $shouldPropagatePassword = $this->option('should-propagate-password');
        $expiresAt = $this->option('expires-at');
        $disabled = $this->option('disabled');

        if (!empty($expiresAt)) $expiresAt = Carbon::parse($expiresAt)->timestamp;

        $client = new AliasClient($this->orm);

        $response = $client->store(
            $username,
            $aliasOwnerID,
            $aliasOwnerUsername,
            $aliasOwnerIdentifier,
            $shouldPropagatePassword,
            $password,
            $expiresAt,
            $disabled
        );

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

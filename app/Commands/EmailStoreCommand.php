<?php

namespace App\Commands;

use openresourcemanager\client\Email as EmailClient;

class EmailStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:store
                            {address : Unique address for the Email object. Must be unique across all emails objects.}
                            {--a|account-id= : Unique primary key ID of email owner. This is required without the identifier or username parameters.}
                            {--i|identifier= : Unique identifier string of the email owner. This is required without the account-id or username parameters.}
                            {--u|username= : Unique username string of the email owner. This is required without the account-id or identifier parameters.}
                            {--c|verification-callback= : A url to redirect verified users to after they verify their email.}
                            {--f|confirmation-from= : A friendly email address to send the verification email from. This allows for contextual verification messages.}
                            {--u|upstream-app-name= : Name of the upstream app posting the email. This allows for contextual verification messages.}
                            {--verified : Determines if this address should be stored as verified and skip the verification process.}
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
    protected $description = 'Store Email information. Creates, updates, restores, an email address based on it\'s current status.';

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

        $address = $this->argument('address');
        $id = (!empty($this->argument('account-id'))) ? $this->argument('account-id') : null;
        $identifier = (!empty($this->option('identifier'))) ? $this->option('identifier') : null;
        $username = (!empty($this->option('username'))) ? $this->option('username') : null;
        $verificationCallback = $this->option('verification-callback');
        $confirmationFrom = $this->option('confirmation-from');
        $upstreamAppName = $this->option('upstream-app-name');
        $verified = $this->option('verified');

        if (empty($id) && empty($identifier) && empty($username)) {
            $this->error('Provide an account-id option, identifier option, or username option to associate with this address.');
            die();
        }

        $client = new EmailClient($this->orm);

        $response = $client->store(
            $id,
            $identifier,
            $username,
            $address,
            $verified,
            $upstreamAppName,
            $verificationCallback,
            $confirmationFrom
        );

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

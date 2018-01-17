<?php

namespace App\Commands;

use openresourcemanager\client\MobilePhone as MobilePhoneClient;

class MobilePhoneStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobile:store
                            {number : Unique phone number for the mobile phone object. Must be unique across all mobile phone objects.}
                            {--a|account-id= : Unique primary key ID of mobile phone owner. This is required without the identifier or username options.}
                            {--i|identifier= : Unique identifier string of the mobile phone owner. This is required without the account-id or username options.}
                            {--u|username= : Unique username string of the mobile phone owner. This is required without the account-id or identifier options.}
                            {--country-code= : The mobile phone country code for this mobile phone object.}
                            {--I|mobile-carrier-id : The mobile carrier ID that this phone belongs to. This is required without the mobile-carrier-code option.}
                            {--C|mobile-carrier-code : The mobile carrier code that this phone belongs to. This is required without the mobile-carrier-id option.}
                            {--c|verification-callback= : A url to redirect verified users to after they verify their mobile phone.}
                            {--U|upstream-app-name= : Name of the upstream app posting the mobile phone. This allows for contextual verification messages.}
                            {--verified : Determines if this mobile phone should be stored as verified and skip the verification process.}
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
    protected $description = 'Store Mobile Phone information. Creates, updates, restores, a mobile phone based on it\'s current status.';

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

        $number = $this->argument('number');
        $id = (!empty($this->option('account-id'))) ? $this->option('account-id') : null;
        $identifier = (!empty($this->option('identifier'))) ? $this->option('identifier') : null;
        $username = (!empty($this->option('username'))) ? $this->option('username') : null;
        $mobileCarrierID = $this->option('mobile-carrier-id');
        $mobileCarrierCode = $this->option('mobile-carrier-code');
        $verificationCallback = $this->option('verification-callback');
        $upstreamAppName = $this->option('upstream-app-name');
        $verified = $this->option('verified');
        $countryCode = $this->option('country-code');

        if (empty($id) && empty($identifier) && empty($username)) {
            $this->error('Provide an account-id option, identifier option, or username option to associate with this address.');
            die();
        }

        if (empty($mobileCarrierID) && empty($mobileCarrierCode)) {
            $this->error('Provide a mobile-carrier-id option or mobile-carrier-code option to associate with this mobile phone.');
            die();
        }

        $client = new MobilePhoneClient($this->orm);

        $response = $client->store(
            $id,
            $identifier,
            $username,
            $number,
            $countryCode,
            $mobileCarrierID,
            $mobileCarrierCode,
            $verified,
            $upstreamAppName,
            $verificationCallback
        );

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

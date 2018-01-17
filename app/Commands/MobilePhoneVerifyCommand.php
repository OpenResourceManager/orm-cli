<?php

namespace App\Commands;

use openresourcemanager\client\ResourceVerification as VerifyClient;

class MobilePhoneVerifyCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobile:verify
                            {token : Unique verification token for the Mobile Phone object.}
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
    protected $description = 'Verify a mobile phone with a verification token.';

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

        $token = $this->argument('token');

        $client = new VerifyClient($this->orm);

        $response = $client->postVerification($token);

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

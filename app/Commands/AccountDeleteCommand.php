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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        parent::handle();

        $id = $this->argument('id');
        $identifier = $this->option('identifier');
        $username = $this->option('username');

        $accountClient = new AccountClient($this->orm);
        $response = null;

        if (empty($id)) {
            if (empty($identifier) && empty($username)) {
                $this->error('No identifying information found. Provide an id, identifier, or username.');
            } elseif (!empty($identifier)) {
                $response = $accountClient->deleteFromIdentifier($identifier);
            } elseif (!empty($username)) {
                $response = $accountClient->deleteFromUsername($username);
            }
        } else {
            $response = $accountClient->delete($id);
        }

        $this->displayResponseCode($response);
    }
}

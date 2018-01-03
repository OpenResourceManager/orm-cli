<?php

namespace App\Commands;


use Carbon\Carbon;
use OpenResourceManager\Client\Account as AccountClient;

class AccountPatchCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:patch
                            {identifier : Unique identifier for account}
                            {--username= : Unique username for account. Must be unique across all accounts, alias accounts, and service accounts}
                            {--name-first= : The first name of the account owner}
                            {--name-last= :  The last name of the account owner}
                            {--name-middle= : The middle name of the account owner}
                            {--name-prefix= : Optional name prefix}
                            {--name-postfix= : Optional name postfix}
                            {--name-phonetic= : Optional phonetic name}
                            {--primary-duty-id= : The primary duty ID for this account. This is required without --primary-duty-code}
                            {--primary-duty-code= : The primary duty Code for this account. This is required without --primary-duty-id}
                            {--load-status-id= : The load status ID for this account}
                            {--load-status-code= : The load status code for this account}
                            {--ssn= : The last four digits of the account owner\'s social security number. This is only available to API consumers who have classified permissions}
                            {--password= : The initial password assigned to this account when it is created. This is only available to API consumers who have classified permissions}
                            {--should-propagate-password : If this is set and a password parameter is supplied third party integrations such as Active Directory will use this password for the account within their systems}
                            {--expires-at= : The account\'s expiration date in string format(yyyy-mm-dd hh:mm) or (yyyy-mm-dd)}
                            {--disabled : Determines if this account is disabled}
                            {--birth-date= : The account owner\'s birth date in string format(yyyy-mm-dd). This is only availble to API consumers who have classified permissions}
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
    protected $description = 'Update existing account information based in it\'s identifier.';

    /**
     * AccountPatchCommand constructor.
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

        $identifier = $this->argument('identifier');
        $username = $this->option('username');
        $nameFirst = $this->option('name-first');
        $nameLast = $this->option('name-last');
        $primaryDutyID = $this->option('primary-duty-id');
        $primaryDutyCode = $this->option('primary-duty-code');
        $loadStatusID = $this->option('load-status-id');
        $loadStatusCode = $this->option('load-status-code');
        $ssn = $this->option('ssn');
        $password = $this->option('password');
        $shouldPropagatePassword = $this->option('should-propagate-password');
        $expiresAt = $this->option('expires-at');
        $disabled = $this->option('disabled');
        $birthDate = $this->option('birth-date');
        $nameMiddle = $this->option('name-middle');
        $namePrefix = $this->option('name-prefix');
        $namePostfix = $this->option('name-postfix');
        $namePhonetic = $this->option('name-phonetic');

        if (!empty($expiresAt)) $expiresAt = Carbon::parse($expiresAt)->timestamp;
        if (!empty($birthDate)) $birthDate = Carbon::parse($birthDate)->timestamp;

        $accountClient = new AccountClient($this->orm);

        $response = $accountClient->patch(
            $identifier,
            $username,
            $namePrefix,
            $nameFirst,
            $nameMiddle,
            $nameLast,
            $namePostfix,
            $namePhonetic,
            $primaryDutyID,
            $primaryDutyCode,
            $ssn,
            $shouldPropagatePassword,
            $password,
            $expiresAt,
            $disabled,
            $birthDate,
            $loadStatusCode,
            $loadStatusID
        );

        // Cache the current ORM object
        $this->cacheORM($accountClient->getORM());
        $this->displayResponseBody($response);
    }
}

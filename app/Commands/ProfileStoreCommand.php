<?php

namespace App\Commands;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileStoreCommand extends ORMCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:store 
                            {--e|email= : Your ORM API email address}
                            {--H|host= : Your ORM API host address}
                            {--p|port= : Your ORM API port}
                            {--a|api-version= : Your ORM API version}
                            {--s|ssl : Connect to ORM via HTTPS}
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
    protected $description = 'Stores ORM API credentials and server information';

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
     * Gathers Email
     *
     * Gets and validates email address
     *
     * @param string $email
     * @return string
     */
    private function getEmail($email = '')
    {
        // If we don't have an email address ask for one
        if (empty($email)) $email = $this->ask('ORM email? (eg: you@example.com)');
        // Make a new validation constructor
        $validator = $this->validation->make(['email' => $email], ['email' => 'required|email|unique:orm_profiles']);
        // Do we pass validation?
        if ($validator->fails()) {
            // Get the errors for email
            $errors = $validator->errors()->getMessages()['email'];
            foreach ($errors as $error) {
                // Loop over them and provide a contextual message based on the error type
                switch ($error) {
                    case 'validation.email':
                        $this->error('The address that you entered is not a valid email address.');
                        break;
                    case 'validation.unique':
                        $this->error('The address that you entered already belongs to a stored profile.');
                        break;
                    case 'validation.required':
                        $this->error('No email address was provided!');
                        break;
                    default:
                        $this->error('Error validating email address.');
                }
            }
            $this->warn('Try again.');
            $email = $this->getEmail();
        }
        return $email;
    }

    /**
     * Gathers API Secret
     *
     * Gets and validates API secret
     *
     * @param string $secret
     * @return string
     */
    private function getSecret($secret = '')
    {
        // If we don't have an email address ask for one
        if (empty($secret)) $secret = $this->secret('ORM API secret? (eg: i0svwyrpu9ve)');
        // Make a new validation constructor
        $validator = $this->validation->make(['secret' => $secret], ['secret' => 'required|string|unique:orm_profiles']);
        // Do we pass validation?
        if ($validator->fails()) {
            // Get the errors for secret
            $errors = $validator->errors()->getMessages()['secret'];
            foreach ($errors as $error) {
                // Loop over them and provide a contextual message based on the error type
                switch ($error) {
                    case 'validation.string':
                        $this->error('The secret that you entered is not a valid string');
                        break;
                    case 'validation.unique':
                        $this->error('The secret that you entered already belongs to a stored profile.');
                        break;
                    case 'validation.required':
                        $this->error('No secret was provided!');
                        break;
                    default:
                        $this->error('Error validating secret.');
                }
            }
            $this->warn('Try again.');
            $secret = $this->getEmail();
        }
        return $secret;
    }

    /**
     * Gathers host ORM address
     *
     * Gets and validates the host address
     *
     * @param string $host
     * @return string
     */
    private function getHost($host = '')
    {
        if (empty($host)) $host = $this->anticipate('ORM API host? (eg: orm.example.com)', ['localhost']);
        $validator = $this->validation->make(['host' => $host], ['host' => 'required|string']);
        // Do we pass validation?
        if ($validator->fails()) {
            // Get the errors for host
            $errors = $validator->errors()->getMessages()['host'];
            foreach ($errors as $error) {
                // Loop over them and provide a contextual message based on the error type
                switch ($error) {
                    case 'validation.string':
                        $this->error('The host that you entered is not a valid string.');
                        break;
                    case 'validation.required':
                        $this->error('No host was provided!');
                        break;
                    default:
                        $this->error('Error validating host address.');
                }
            }
            $this->warn('Try again.');
            $host = $this->getHost();
        }
        return $host;
    }

    /**
     * Gathers host port
     *
     * Gets and validates the host port
     *
     * @param int $port
     * @return int|string
     */
    private function getPort($port = 0)
    {
        if (empty($port)) $port = $this->anticipate('ORM API port?', [80, 443]);
        $validator = $this->validation->make(['port' => $port], ['port' => 'required|integer']);
        // Do we pass validation?
        if ($validator->fails()) {
            // Get the errors for port
            $errors = $validator->errors()->getMessages()['port'];
            foreach ($errors as $error) {
                // Loop over them and provide a contextual message based on the error type
                switch ($error) {
                    case 'validation.integer':
                        $this->error('The port that you entered is not a valid integer.');
                        break;
                    case 'validation.required':
                        $this->error('No port was provided!');
                        break;
                    default:
                        $this->error('Error validating host address.');
                }
            }
            $this->warn('Try again.');
            $port = $this->getHost();
        }
        return $port;
    }

    /**
     * Stores ORM connection profile
     *
     * @param string $email
     * @param string $secret
     * @param string $host
     * @param int $port
     * @param string $version
     * @param bool $use_ssl
     */
    private function storeProfile($email, $secret, $host, $port, $version, $use_ssl)
    {
        $this->info('Storing profile...');
        $bar = $this->output->createProgressBar(1);
        $now = Carbon::now('UTC')->toDateTimeString();
        $found_active = false;

        $profiles = DB::table('orm_profiles')->get();

        foreach ($profiles as $profile) {
            if (!$found_active) {
                if ($profile->active) {
                    $found_active = true;
                }
            }
        }

        DB::table('orm_profiles')->insert(
            [
                'email' => $email,
                'active' => ($found_active) ? false : true,
                'secret' => $secret,
                'host' => $host,
                'port' => $port,
                'version' => $version,
                'use_ssl' => $use_ssl,
                'created_at' => $now,
                'updated_at' => $now
            ]
        );
        $bar->finish();
        $this->info("\nProfile stored!");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $email = $this->getEmail($this->option('email'));
        $secret = $this->getSecret();
        $host = $this->getHost($this->option('host'));
        $port = $this->getPort($this->option('port'));

        $ver_str = strtolower(strval($this->option('api-version')));
        if ($ver_str === '1' || $ver_str === 'v1') {
            $version = 1;
        } else {
            $choice = $this->choice('ORM API version?', ['v1'], 0);
            switch ($choice) {
                case 'v1':
                    $version = 1;
                    break;
                default:
                    $version = 1;
            }
        }
        if ($this->option('ssl')) {
            $use_ssl = true;
        } else {
            $use_ssl = $this->confirm('Use HTTPS?') ? true : false;
        }

        $this->info('Options seem valid!');
        // Store the profile
        $this->storeProfile($email, $secret, $host, $port, $version, $use_ssl);
    }
}

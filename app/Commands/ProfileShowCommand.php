<?php

namespace App\Commands;

class ProfileShowCommand extends ProfileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:show {--s|secret : Display profiles with API secret}';

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
    protected $description = 'Displays stored profiles';

    /**
     * ProfileShowCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $profiles = $this->getProfiles();
        $data = [];
        if ($this->option('secret')) {
            $header = ['id', 'active', 'email', 'secret', 'host', 'port', 'api version', 'use ssl', 'created', 'updated'];
            foreach ($profiles as $profile) {
                $active = ($profile->active) ? 'Yes' : 'No';
                $use_ssl = ($profile->use_ssl) ? 'Yes' : 'No';
                $data[] = [
                    $profile->id,
                    $active,
                    $profile->email,
                    $profile->secret,
                    $profile->host,
                    $profile->port,
                    $profile->version,
                    $use_ssl,
                    $profile->created_at . ' (UTC)',
                    $profile->updated_at . ' (UTC)'
                ];
            }
        } else {
            $header = ['id', 'active', 'email', 'host', 'port', 'api version', 'use ssl', 'created', 'updated'];
            foreach ($profiles as $profile) {
                $active = ($profile->active) ? 'Yes' : 'No';
                $use_ssl = ($profile->use_ssl) ? 'Yes' : 'No';
                $data[] = [
                    $profile->id,
                    $active,
                    $profile->email,
                    $profile->host,
                    $profile->port,
                    $profile->version,
                    $use_ssl,
                    $profile->created_at . ' (UTC)',
                    $profile->updated_at . ' (UTC)'
                ];
            }
        }
        $this->table($header, $data);
    }
}

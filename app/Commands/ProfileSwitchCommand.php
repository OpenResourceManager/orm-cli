<?php

namespace App\Commands;

class ProfileSwitchCommand extends ProfileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:switch';

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
    protected $description = 'Switch the currently active ORM profile';

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
        $profiles = $this->getProfiles();
        if (!empty($profiles)) {
            $this->warn('Which profile should be active?');
            $id = $this->offerProfiles($profiles);
            $this->switchProfiles($profiles, $id);
        } else {
            $this->warn('No profiles found... hint: orm profile:store');
        }
    }
}

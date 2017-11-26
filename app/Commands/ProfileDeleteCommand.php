<?php

namespace App\Commands;

class ProfileDeleteCommand extends ProfileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:delete';

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
    protected $description = 'Delete a stored ORM profile';

    /**
     * ProfileDeleteCommand constructor.
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
        if (!empty($profiles)) {
            $this->warn('Which profile should be deleted?');
            $is_active = false;
            $id = $this->offerProfiles($profiles);
            foreach ($profiles as $profile) {
                if($profile->id == $id) {
                    $is_active = $profile->active;
                }
            }
            $this->deleteProfile($id);
            if($is_active) {
                $profiles = $this->getProfiles();
                $this->warn('The active profile was deleted. Which profile should be active?');
                $id = $this->offerProfiles($profiles);
                $this->switchProfiles($profiles, $id);
            }
            $this->info('Done!');
        } else {
            $this->warn('No profiles found... hint: orm profile:store');
        }

    }
}

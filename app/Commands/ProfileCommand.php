<?php

namespace App\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileCommand extends ORMCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * ProfileCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Gets profiles
     *
     * @return Collection
     */
    public function getProfiles(): Collection
    {
        return DB::table('orm_profiles')->get();
    }

    /**
     * Gets the active profile
     *
     * @return \stdClass
     */
    public function getActiveProfile(): \stdClass
    {
        $profile = false;
        $profiles = DB::select('select * from orm_profiles where active = 1');
        if (count($profiles) < 1) {
            $this->warn('No profiles found... hint: orm profile:store');
        } else if (count($profiles) > 1) {
            $this->warn('More than one active profile found, chose one');
            $choices = $this->getProfiles();
            $choice = $this->offerProfiles($choices);
            $this->switchProfiles($choices, $choice);
            $profile = $this->getActiveProfile();
        } else if (count($profiles) == 1) {
            $profile = $profiles[0];
        }

        return $profile;
    }

    /**
     * Shows profiles
     *
     * Shows profiles and allows user to pick one
     *
     * @param $profiles
     * @return int
     */
    public function offerProfiles($profiles): int
    {
        $profiles = json_decode(json_encode($profiles, true));
        $options = [];

        if (!empty($profiles)) {
            foreach ($profiles as $profile) {
                $protocol = ($profile->use_ssl) ? 'https://' : 'http://';
                $slug = ':' . $profile->port . '/api/v' . $profile->version;
                $url = $protocol . $profile->host . $slug;
                if ($profile->active) {
                    $options[$profile->id] = $profile->id . ' ' . $profile->email . ' - ' . $url . ' <---(active';
                } else {
                    $options[$profile->id] = $profile->id . ' ' . $profile->email . ' - ' . $url;
                }
            }
            return intval(explode(' ', $this->choice('Select a profile', $options))[0]);
        } else {
            $this->warn('No profiles found... hint: orm profile:store');
            die();
        }
    }

    /**
     * Switches the active
     *
     * @param $profiles
     * @param $id
     */
    public function switchProfiles($profiles, $id): void
    {
        $this->info('Switching active profile');
        foreach ($profiles as $profile) {
            if ($profile->active) {
                $now = Carbon::now('UTC')->toDateTimeString();
                DB::update('update orm_profiles set active = 0, updated_at = ? where id = ?', [$now, $profile->id]);
            }
        }
        $now = Carbon::now('UTC')->toDateTimeString();
        DB::update('update orm_profiles set active = 1, updated_at = ? where id = ?', [$now, $id]);
        $this->info('Done!');
    }

    /**
     * Deletes a profile
     *
     * @param $id
     */
    public function deleteProfile($id): void
    {
        $this->info('Deleting profile');
        DB::delete('delete from orm_profiles WHERE id = ?', [$id]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {

    }
}

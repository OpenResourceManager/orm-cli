<?php

namespace App\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;

class ORMCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:orm';

    /**
     * Hide this command
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Used to validate command input
     *
     * @var
     */
    protected $validation;

    /**
     * ORMCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->validation = $this->initValidator();
    }

    /**
     * Initializes validator
     *
     * Creates a new validation factory
     *
     * @return Factory
     */
    private function initValidator(): Factory
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ORM_DB_PATH,
        ]);
        $loader = new FileLoader(new Filesystem, 'lang');
        $translator = new Translator($loader, 'en');
        $presence = new DatabasePresenceVerifier($capsule->getDatabaseManager());
        $validation = new Factory($translator, new Container);
        $validation->setPresenceVerifier($presence);
        return $validation;
    }

    /**
     * Execute the console command
     *
     * @return void
     */
    public function handle(): void
    {

    }

    /**
	 * Define the command's schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 *
	 * @return void
	 */
	public function schedule(Schedule $schedule): void
	{

	}
}

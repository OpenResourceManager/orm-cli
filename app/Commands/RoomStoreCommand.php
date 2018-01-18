<?php

namespace App\Commands;

use openresourcemanager\client\Room as RoomClient;

class RoomStoreCommand extends APICommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'room:store
                            {code : Unique code for the room. Must be unique across all room.}
                            {room-number : The number assigned to this room.}
                            {--b|building-id : The id of a building that this rooms resides in. This is required without the --building-code option.}
                            {--c|building-code : The code of a building that this rooms resides in. This is required without the --building-id option.}
                            {--n|floor-number : The floor number that this room is on.}
                            {--f|floor-label : A label assigned to the floor that this room is on.}
                            {--l|room-label : A label assigned to this room.}
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
    protected $description = 'Store Room information. Creates, updates, restores, a room based on it\'s current status.';

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

        $code = $this->argument('code');
        $roomNumber = $this->argument('room-number');
        $buildingID = $this->option('building-id');
        $buildingCode = $this->option('building-code');
        $floorNumber = $this->option('floor-number');
        $floorLabel = $this->option('floor-label');
        $roomLabel = $this->option('room-label');

        if (empty($buildingCode) && empty($buildingID)) {
            $this->error('Provide a building-id option or building-code option.');
            die();
        }

        $client = new RoomClient($this->orm);

        $response = $client->store(
            $code,
            $roomNumber,
            $roomLabel,
            $buildingID,
            $buildingCode,
            $floorNumber,
            $floorLabel
        );

        // Cache the current ORM object
        $this->cacheORM($client->getORM());
        $this->displayResponseBody($response);
    }
}

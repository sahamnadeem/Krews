<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;

class CreateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $admin = Role::create([
            'name'=>'admin',
            'display_name'=>'Admin',
            'description'=> 'Administration',
        ]);
        $user = Role::create([
            'name'=>'user',
            'display_name'=>'User',
            'description'=> 'User',
        ]);
        $this->info('Roles created successfully!');
    }
}

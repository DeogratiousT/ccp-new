<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class UpdateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command updates all roles with their respective abilities defined in the roles config file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
$roles = config('roles.roles');
        
        try {
            foreach ($roles as $role) {
                Role::updateOrCreate([
                    'name' => ucwords($role)
                ]);
            }
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
        

        return $this->info('You have successfully updated your roles.');
    }
}

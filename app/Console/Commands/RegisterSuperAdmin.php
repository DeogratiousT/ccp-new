<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class RegisterSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers Super Administrator';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $role = Role::orderBy('name');

        if (! $role->exists()) {
            $this->error('Roles definitions have not been run.
            please update the role definitions first using  php artisan roles:update command');
            return;
        }

        $name = $this->ask('Enter full name');
        $email = $this->ask('Enter the admin Email address');

       while(! $this->isValidEmail($email)){
           $this->error('Email is invalid');
           $email = $this->ask('Email the admin Email address again');
       }

       $password = $this->secret('Enter the admin\'s password?');

       while (! $this->isRequiredLength($password)) {
           $this->error('Password must be more that eight characters');
           $password = $this->secret('Enter the admin\'s password?');
       }

       $confirmPassword = $this->secret('Confirm the admin\'s password?');
           
       while (! $this->isMatch($password, $confirmPassword)) {
           $this->error('Password and Confirm password do not match');

           $password = $this->secret('Enter new admin\'s password?');

           while (! $this->isRequiredLength($password)) {
               $this->error('Password must be more that six characters');
               $password = $this->secret('Enter new admin\'s password?');
           }

           $confirmPassword = $this->secret('Confirm the admin\'s password?');
       }

       $user = new User();
       $user->name = $name;
       $user->email = $email;
       $user->email_verified_at = Carbon::now();
       $user->password = Hash::make($password);
       $user->save();

       try {
            $user->assignRole('Super Admin');
       } catch (\Throwable $th) {
            $user->delete();
            $this->error($th->getMessage());
            die();
       }

       $this->display($user);

    }

    /**
    * Dispaly the registered Admin details
    * 
    * @return table
    */

   private function display(User $admin) : void
   {
       $headers = ['Name', 'Email'];

       $fields = [
           'Name' => $admin->name,
           'Email' => $admin->email,
       ];

       $this->info('Super admin created successfully');
       $this->table($headers, [$fields]);
   }

   /**
    * Check if email is valid
    *
    * @param string $email
    * @return boolean
    */
   private function isValidEmail(string $email) :bool
   {
       return filter_var($email, FILTER_VALIDATE_EMAIL);
   }

   /**
    * Check if password and confirm password matches.
    *
    * @param string $password
    * @param string $confirmPassword
    * @return bool
    */
   private function isMatch(string $password, string $confirmPassword) : bool
   {
       return $password === $confirmPassword;
   }

   /**
    * Checks if password is longer than eight characters.
    *
    * @param string $password
    * @return bool
    */
   private function isRequiredLength(string $password) : bool
   {
       return strlen($password) > 8;
   }

   /**
    * Checks if phone number is longer than ten characters.
    *
    * @param string $phone_number
    * @return bool
    */
    private function isValidPhone(string $phone_number) : bool
   {
       return strlen($phone_number) > 10;
   }
}

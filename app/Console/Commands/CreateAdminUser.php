<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin-user {name} {email} {phone} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un utilisateur avec le rôle d\'admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $phone = $this->argument('phone');
        $password = $this->argument('password');

        // Créer l'utilisateur
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password),
        ]);

        // Assigner le rôle d'admin à l'utilisateur
        $user->assignRole('admin');

        $this->info('Admin user created successfully.');

        return 0;
    }
}

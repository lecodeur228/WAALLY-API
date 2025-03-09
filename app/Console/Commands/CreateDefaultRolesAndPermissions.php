<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateDefaultRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */ 
    protected $signature = 'app:create-default-roles-and-permissions';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer des rôles et des permissions prédéfinis';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
          // Définir les rôles et les permissions
          $roles = ['admin', 'owner', 'seller'];
          $permissions = ['manage shop', 'manage owner' ,'manage seller', 'manage articles', 'manage finance', 'manage stock', 'manage vente'];
  
          // Créer les rôles
          foreach ($roles as $role) {
              Role::firstOrCreate(['name' => $role]);
          }
  
          // Créer les permissions
          foreach ($permissions as $permission) {
              Permission::firstOrCreate(['name' => $permission]);
          }
  
          // Assigner les permissions aux rôles
          $adminRole = Role::findByName('admin');
          $adminRole->givePermissionTo(["manage shop","manage owner"]);
  
          $ownerRole = Role::findByName('owner');
          $ownerRole->givePermissionTo(['manage articles', 'manage finance', 'manage stock', 'manage seller']);
  
          $sellerRole = Role::findByName('seller');
          $sellerRole->givePermissionTo(["manage vente"]);

          $this->info('Rôles et permissions créés avec succès.');
  
    }
}

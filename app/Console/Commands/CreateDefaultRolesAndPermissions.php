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
          $permissions = [
            //'manage boutique',
            'create shop',
            'update shop',
            'delete shop',
            'view shop',
            //'manage owner',
            'create owner',
            'update owner',
            'delete owner',
            'view owner',
            //'manage seller'
            'ceate seller',
            'update seller',
            'delete seller',
            'view seller',
            //'manage articles',
            'create articles',
            'update articles',
            'delete articles',
            'view articles',
            //'manage finance',
            'create finance',
            'update finance',
            'delete finance',
            'view finance',
            //'manage stock',
            'create stock',
            'update stock',
            'delete stock',
            'view stock',
            //'manage ventes'
            'create sale',
            'update sale',
            'delete sale',
            'view sale',
            //manage store
            'create store',
            'update store',
            'delete store',
            'view store',
            //manage customer
            'create customer',
            'update customer',
            'delete customer',
            'view customer',
            // manage magazines
            'create magazines',
            'update magazines',
            'delete magazines',
            'view magazines',
            // manage approvs
            'create approvs',
            'update approvs',
            'delete approvs',
            'view approvs',
            // manage wallet
            'create wallet',
            'update wallet',
            'delete wallet',
            'view wallet',
        ];

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
          $adminRole->givePermissionTo(
            [
            //"manage boutique",
            'create shop',
            'update shop',
            'delete shop',
            'view shop',
            //"manage owner",
            'create owner',
            'update owner',
            'delete owner',
            'view owner',
            ]
        );

          $ownerRole = Role::findByName('owner');
          $ownerRole->givePermissionTo(
            [
            //'manage articles',
            'create articles',
            'update articles',
            'delete articles',
            'view articles',
            //'manage finance',
            'create finance',
            'update finance',
            'delete finance',
            'view finance',
            //'manage stock',
            'create stock',
            'update stock',
            'delete stock',
            'view stock',
            //'manage seller'
            'ceate seller',
            'update seller',
            'delete seller',
            'view seller',
            //manage store
            'create store',
            'update store',
            'delete store',
            'view store',
            //"manage boutique",
            'create shop',
            'update shop',
            'delete shop',
            'view shop',
            //manage customer
            'create customer',
            'update customer',
            'delete customer',
            'view customer',
            //manage magazines
            'create magazines',
            'update magazines',
            'delete magazines',
            'view magazines',
            // manage wallets
            'create wallets',
            'update wallets',
            'delete wallets',
            'view wallets',
            // manage approvs
            'create approvs',
            'update approvs',
            'delete approvs',            
            'view approvs', 
            ]);

        $sellerRole = Role::findByName('seller');
        $sellerRole->givePermissionTo(
            [
            //"manage vente"
            'create sale',
            'update sale',
            'delete sale',
            'view sale'
            ]
        );

        $this->info('Rôles et permissions créés avec succès.');

    }
}

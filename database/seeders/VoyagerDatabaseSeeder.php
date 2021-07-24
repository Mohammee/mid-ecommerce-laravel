<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class VoyagerDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedersPath = database_path('seeders').'/';
        $this->seed(DataTypesTableSeeder::class);
        $this->seed(DataRowsTableSeeder::class);
        $this->seed(MenusTableSeeder::class);
        $this->seed(MenuItemsTableSeeder::class);
        $this->seed(RolesTableSeeder::class);
        $this->seed(PermissionsTableSeeder::class);
        $this->seed(PermissionRoleTableSeeder::class);
        $this->seed(SettingsTableSeeder::class);
    }
}

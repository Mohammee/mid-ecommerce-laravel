<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EcommerceInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecommerce:install {--f|force : Do not ask for user confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install dumy data for ecommerce application';

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
        if(!$this->option('force'))
        {
            if ($this->confirm('This delete all your data and install default dumy data , Are you sure ?')) {
                $this->proceed();
            }
        }
        else{
            $this->proceed();
        }


        $this->info('Dumy data install successfully.');
        return 0;
    }



    protected function proceed()
    {
        File::deleteDirectory(storage_path('app/public/products/dummy'));

        $this->callSilent('storage:link');
        $copySuccess = File::copyDirectory(public_path('img/products'), public_path('storage/products/dummy'));
        if ($copySuccess) {
            $this->info('Image copied successfully to storage folder.');
        }


        $this->call('migrate:fresh', [
            '--seed' => true,
            '--force' => true
        ]);
        $this->call('db:seed', [
            '--class' => 'PermissionsTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'VoyagerDatabaseSeeder',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'VoyagerDummyDatabaseSeeder',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'DataTypesTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'DataRowsTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'MenusTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'MenuItemsTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'RolesTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'PermissionRoleTableSeeder',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'PermissionRoleTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'UsersTableSeederCustom',
            '--force' => true,
        ]);

        $this->call('db:seed', [
            '--class' => 'SettingsTableSeederCustom',
            '--force' => true,
        ]);

        try {
            $this->call('scout:clear', [
                'model' => 'App\Models\Product'
            ]);
            $this->call('scout:import', [
                'model' => 'App\Models\Product'
            ]);
        }catch (\Exception $e)
        {
            $this->error('Algolia Credentails incorrect. Check your. Make sure Algolia_API_ID and Algolia_API_SECRET are correct. ');
        }
    }
}

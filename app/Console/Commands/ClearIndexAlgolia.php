<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearIndexAlgolia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:clear {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear all data in search index, regardless of database';

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
       $class =  $this->argument('model');
       $model = new $class;

        $algolia = \Algolia\AlgoliaSearch\SearchClient::create(
            config('scout.algolia.id'),
            config('scout.algolia.secret')
        );

        //remember is synchonize

        $index = $algolia->initIndex($model->searchableAs());
        $index->delete();

        $this->info('Index ' . $model->searchableAs() . ' Cleared!');
        return 0;
    }
}

<?php namespace App\Console\Commands;

// Core
use Illuminate\Console\Command;

// Models
use App\Models\Plugin;

class AddPlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:plugin {name} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a plugin to the database';

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
     * @return mixed
     */
    public function handle()
    {
        $plugin = new Plugin;
        $plugin->name = $this->argument('name');
        $plugin->description = $this->argument('description');
        $plugin->save();
    }
}

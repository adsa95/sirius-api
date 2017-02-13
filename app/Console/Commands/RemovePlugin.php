<?php namespace App\Console\Commands;

// Core
use Illuminate\Console\Command;

// Models
use App\Models\Plugin;

class RemovePlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:plugin {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a plugin';

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
        $name = $this->argument('name');
        $plugin = Plugin::where('name', '=', $name);
        $plugin->delete();
    }
}

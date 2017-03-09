<?php namespace App\Console\Commands;

// Core
use Illuminate\Console\Command;

// Models
use App\Models\Extension;

class RemoveExtension extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:remove {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an extension by its EID';

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
        $extension = Extension::where('name', '=', $name);
        $extension->delete();
    }
}

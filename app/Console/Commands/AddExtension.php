<?php namespace App\Console\Commands;

// Core
use Illuminate\Console\Command;

// Models
use App\Models\Extension;

class AddExtension extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:add {name} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an extension to the database';

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
        $extension = new Extension();
        $extension->name = $this->argument('name');
        $extension->description = $this->argument('description');
        $extension->save();
    }
}

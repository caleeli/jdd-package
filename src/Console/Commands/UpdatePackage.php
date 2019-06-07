<?php

namespace JDD\Example\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use JDD\Example\PackageServiceProvider;

class UpdatePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     *
     * @var string
     */
    protected $signature = 'example:jdd-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the installed jdd package';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Build asset: ' . $this->signature);
        $dir = getcwd();
        chdir(__DIR__ . '/../../../');
        exec('npm run build');
        chdir($dir);
        //File::deleteDirectory(public_path('/modules/' . PackageServiceProvider::PluginName));
        $this->call('vendor:publish', ['--provider' => PackageServiceProvider::class, '--force' => true]);
    }
}

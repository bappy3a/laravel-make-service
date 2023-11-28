<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServiceMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $codeToAdd = "\n\t\t\$this->app->bind(\n".
                "\t\t\t\\App\\Interfaces\\".str_replace('/', '\\', $this->argument('name'))."Interface::class,\n".
                "\t\t\t\\App\\Services\\".str_replace('/', '\\', $this->argument('name'))."::class\n".
                "\t\t);\n";

        $appServiceProviderFile = app_path('Providers/RepositoryServiceProvider.php');

        $this->injectCodeToRegisterMethod($appServiceProviderFile, $codeToAdd);

        Artisan::call('make:interface', [
            'name' => $this->argument('name').'Interface',
        ]);

        return parent::handle();
    }

    protected function getStub()
    {
        return __DIR__.'/../../../stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Services';
    }
}

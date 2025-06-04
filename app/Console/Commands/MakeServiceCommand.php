<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services/' . $name . '.php');
        
        if (File::exists($servicePath)) {
            $this->error('Service already exists!');
            return;
        }
        
        File::ensureDirectoryExists(app_path('Services'));
        
        $stub = File::get(__DIR__.'/stubs/service.stub');
        $stub = str_replace('{{ServiceName}}', $name, $stub);
        
        File::put($servicePath, $stub);
        
        $this->info('Service created successfully: ' . $name);
    }
}

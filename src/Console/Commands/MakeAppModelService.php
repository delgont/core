<?php

namespace Delgont\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Delgont\Core\Entities\Any;

class MakeAppModelService extends Command
{

    protected $signature = 'make-service {name} {--model= : Model}';
    protected $description = 'Create a new model service class in the main app';

    public function handle()
    {
        $model = $this->option('model');

        if (!$model) {
            $this->error('Please provide a model using the --model option.');
            return;
        }

        $serviceClassName = Str::studly($this->argument('name'));

        $stubs = $this->getStubs();

        $servicePath = $this->getServicePath($serviceClassName);
        $modelCacheKeysPath = $this->getModelCacheKeyPath($model);

        if (File::exists($servicePath)) {
            $this->error("Service {$servicePath} already exists!");
            return;
        }

        $this->makeDirectory($servicePath);

        file_put_contents($servicePath, strtr($stubs->service, [
            '{{ serviceNamespace }}' => 'App\Services',
            '{{ class }}' => $serviceClassName,
            '{{ modelNamespace }}' => $this->getQualifiedClass($model),
            '{{ model }}' => class_basename($this->getQualifiedClass($model)),
            '{{ modelCacheKeys }}' => 'App\Cache\CacheKeys\\'.class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("INFO Service [{$servicePath}] created successfully.");

        // CacheKeys file
        if (File::exists($modelCacheKeysPath)) {
            $this->error("CacheKeys {$modelCacheKeysPath} already exists!");
            return;
        }

        $this->makeDirectory($modelCacheKeysPath);

        file_put_contents($modelCacheKeysPath, strtr($stubs->cachekeys, [
            '{{ namespace }}' => 'App\Cache\CacheKeys',
            '{{ class }}' => class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("INFO ModelCacheKeys [{$modelCacheKeysPath}] created successfully.");

        return 0;
    }

    protected function getServicePath($serviceClassName)
    {
        return base_path('app/Services/'.class_basename($serviceClassName).'.php');
    }

    protected function getModelCacheKeyPath($model)
    {
        return base_path('app/Cache/CacheKeys/'.class_basename($this->getQualifiedClass($model)).'CacheKeys.php');
    }

    protected function makeDirectory($path)
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }
    }

    protected function getStubs(): Any
    {
        return new Any([
            'service' => file_get_contents(__DIR__.'/../../../stubs/service.stub'),
            'cachekeys' => file_get_contents(__DIR__.'/../../../stubs/cachekeys.stub'),
        ]);
    }

    protected function getQualifiedClass($class)
    {
        return str_replace('/', '\\', $class);
    }
}

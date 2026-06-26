<?php
namespace Delgont\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Delgont\Core\Entities\Any;

class MakeModuleModelService extends Command
{
    protected $signature = 'module:make-service {name} {--model= : Model} {module}';
    protected $description = 'Create a new model service class';

    public function handle()
    {
        $model = $this->option('model');
        $module = $this->argument('module');

        if (!$model) {
            $this->error('Please provide a model using the --model option.');
            return;
        }

        $serviceClassName = Str::ucfirst($this->argument('name'));

        $stubs = $this->getStubs();

        $servicePath = $this->getServicePath($serviceClassName, $module);

        $modelCacheKeysPath = $this->getModelCacheKeyPath($module, $model);


        if (File::exists($servicePath)) {
            $this->error("Service {$servicePath} already exists!");
            return;
        }

        $this->makeDirectory($servicePath);

        file_put_contents($servicePath, strtr($stubs->service, [
            '{{ serviceNamespace }}' => 'Modules\\'.$module.'\Services',
            '{{ class }}' => $serviceClassName,
            '{{ modelNamespace }}' => $this->getQualifiedClass($model),
            '{{ model }}' => class_basename($this->getQualifiedClass($model)),
            '{{ modelCacheKeys }}' => 'Modules\\'.$module.'\Cache\CacheKeys\\'.class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("INFO Serice [{$servicePath}] created successfully.");
        
        # Check if the cachekey file already exists.
        if (File::exists($modelCacheKeysPath)) {
            $this->error("Service {$modelCacheKeysPath} already exists!");
            return;
        }
        $this->makeDirectory($modelCacheKeysPath);

        file_put_contents($modelCacheKeysPath, strtr($stubs->cachekeys,[
            '{{ namespace }}' => 'Modules\\'.$module.'\Cache\CacheKeys',
            '{{ class }}' => class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("INFO ModelCacheKeys [{$modelCacheKeysPath} created successfully.");

        return 0;
    }

    /**
     * Get the full path to a repository class file within a specified module.
     *
     * @param string $repositoryClassName
     * @param string $module
     * @return string
     */
    protected function getServicePath($serviceClassName, $module)
    {
        return base_path('Modules/'.$module.'/Services/'.class_basename($serviceClassName) . '.php');
    }

    protected function getModelCacheKeyPath($module, $model)
    {
        return base_path('Modules/'.$module.'/Cache/CacheKeys/' . class_basename($this->getQualifiedClass($model)) . 'CacheKeys.php');
    }


    protected function makeDirectory($path)
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }
    }


    protected function getStubs() : Any
    {
        return new Any([
            'service' => file_get_contents(__DIR__ . '/../../../stubs/service.stub'),
            'cachekeys' => file_get_contents(__DIR__ . '/../../../stubs/cachekeys.stub'),
        ]);
    }

    protected function getQualifiedClass($class)
    {
        return str_replace('/', '\\', $class);
    }
    
}

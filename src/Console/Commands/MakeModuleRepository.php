<?php
namespace Delgont\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Delgont\Core\Entities\Any;

class MakeModuleRepository extends Command
{
    protected $signature = 'module:make-repo {name} {--model= : The model for which the repository is being created} {module}';

    protected $description = 'Create a new repository class';

    public function handle()
    {
        $model = $this->option('model');
        $module = $this->argument('module');

        if (!$model) {
            $this->error('Please provide a model using the --model option.');
            return;
        }

        $repositoryClassName = Str::ucfirst($this->argument('name'));
        $stubs = $this->getStubs();
        $repositoryPath = $this->getRepositoryPath($repositoryClassName, $module);

        $modelCacheKeysPath = $this->getModelCacheKeyPath($module, $model);

        $modelObserverPath = $this->getModelObserverPath($module,$model);

        # Check if the repository file already exists.
        if (File::exists($repositoryPath)) {
            $this->error("Repository {$repositoryClassName} already exists!");
            return;
        }

        $this->makeDirectory($repositoryPath);

        file_put_contents($repositoryPath, strtr($stubs->repository, [
            '{{ repositoryNamespace }}' => 'Modules\\'.$module.'\Repositories',
            '{{ class }}' => $repositoryClassName,
            '{{ modelNamespace }}' => $this->getQualifiedClass($model),
            '{{ model }}' => class_basename($this->getQualifiedClass($model)),
            '{{ modelCacheKeys }}' => 'Modules\\'.$module.'\Cache\CacheKeys\\'.class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("INFO Repository [{$repositoryPath}] created successfully.");


        
        # Check if the cachekey file already exists.
        if (File::exists($modelCacheKeysPath)) {
            $this->error("Repository {$modelCacheKeysPath} already exists!");
            return;
        }
        $this->makeDirectory($modelCacheKeysPath);

        file_put_contents($modelCacheKeysPath, strtr($stubs->cachekeys,[
            '{{ namespace }}' => 'Modules\\'.$module.'\Cache\CacheKeys',
            '{{ class }}' => class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("INFO ModelCacheKeys [{$modelCacheKeysPath} created successfully.");

        # Check if the observer file already exists.
        if (File::exists($modelObserverPath)) {
            $this->error("Observer {$modelObserverPath} already exists!");
            return;
        }else{
            $this->info('check');
        }

        $this->makeDirectory($modelObserverPath);

        file_put_contents($modelObserverPath, strtr($stubs->observer,[
            '{{ observerNamespace }}' => 'Modules\\'.$module.'\Observers',
            '{{ class }}' => class_basename($this->getQualifiedClass($model)).'Observer',
            '{{ modelNamespace }}' => $this->getQualifiedClass($model),
            '{{ model }}' => class_basename($this->getQualifiedClass($model)),
            '{{ modelCacheKeysNamespace }}' => 'Modules\\'.$module.'\Cache\CacheKeys\\'.class_basename($this->getQualifiedClass($model)).'CacheKeys',
            '{{ modelCacheKeys }}' => class_basename($this->getQualifiedClass($model)).'CacheKeys',
            '{{ plural_model }}' => Str::plural(strtolower(class_basename($this->getQualifiedClass($model))))

        ]));


        return 0;
    }

    /**
     * Get the full path to a repository class file within a specified module.
     *
     * @param string $repositoryClassName
     * @param string $module
     * @return string
     */
    protected function getRepositoryPath($repositoryClassName, $module)
    {
        return base_path('Modules/'.$module.'/Repositories/'.class_basename($repositoryClassName) . '.php');
    }

    protected function getModelCacheKeyPath($module, $model)
    {
        return base_path('Modules/'.$module.'/Cache/CacheKeys/' . class_basename($this->getQualifiedClass($model)) . 'CacheKeys.php');
    }

    protected function getModelObserverPath($module, $model)
    {
        return base_path('Modules/'.$module.'/Observers/' . class_basename($this->getQualifiedClass($model)) . 'Observer.php');
    }

    protected function makeDirectory($path)
    {
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }
    }

    protected function getStub()
    {
        return file_get_contents(__DIR__ . '/../../../stubs/repository.stub');
    }

    protected function getStubs() : Any
    {
        return new Any([
            'repository' => file_get_contents(__DIR__ . '/../../../stubs/repository.stub'),
            'cachekeys' => file_get_contents(__DIR__ . '/../../../stubs/cachekeys.stub'),
            'observer' => file_get_contents(__DIR__ . '/../../../stubs/observer.stub'),
        ]);
    }

    protected function getQualifiedClass($class)
    {
        return str_replace('/', '\\', $class);
    }
    
}

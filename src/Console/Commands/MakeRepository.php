<?php
namespace Delgont\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Delgont\Core\Entities\Any;

class MakeRepository extends Command
{
    protected $signature = 'make:repo {name} {--model= : The model for which the repository is being created}';
    protected $description = 'Create a new repository class';

    public function handle()
    {
        $model = $this->option('model');

        if (!$model) {
            $this->error('Please provide a model using the --model option.');
            return;
        }

        $repositoryClassName = Str::ucfirst($this->argument('name'));
        $stubs = $this->getStubs();
        $repositoryPath = $this->getRepositoryPath($repositoryClassName);
        $modelCacheKeysPath = $this->getModelCacheKeyPath($model);

        $modelObserverPath = $this->getModelObserverPath($model);


        if (File::exists($repositoryPath)) {
            $this->error("Repository {$repositoryClassName} already exists!");
            return;
        }

        $this->makeDirectory($repositoryPath);

        file_put_contents($repositoryPath, strtr($stubs->repository, [
            '{{ repositoryNamespace }}' => 'App\Repositories',
            '{{ class }}' => $repositoryClassName,
            '{{ modelNamespace }}' => $this->getQualifiedClass($model),
            '{{ model }}' => class_basename($this->getQualifiedClass($model)),
            '{{ modelCacheKeys }}' => 'App\Cache\CacheKeys\\'.class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("INFO Repository [{$repositoryPath}] created successfully.");

        # Check if the cachekey file already exists.
        if (File::exists($modelCacheKeysPath)) {
            $this->error("{$modelCacheKeysPath} already exists!");
            return;
        }
        $this->makeDirectory($modelCacheKeysPath);

        file_put_contents($modelCacheKeysPath, strtr($stubs->cachekeys,[
            '{{ namespace }}' => 'App\Cache\CacheKeys',
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
            '{{ observerNamespace }}' => 'App\Observers',
            '{{ class }}' => class_basename($this->getQualifiedClass($model)).'Observer',
            '{{ modelNamespace }}' => $this->getQualifiedClass($model),
            '{{ model }}' => class_basename($this->getQualifiedClass($model)),
            '{{ modelCacheKeysNamespace }}' => 'App\Cache\CacheKeys\\'.class_basename($this->getQualifiedClass($model)).'CacheKeys',
            '{{ modelCacheKeys }}' => class_basename($this->getQualifiedClass($model)).'CacheKeys',
            '{{ plural_model }}' => Str::plural(strtolower(class_basename($this->getQualifiedClass($model))))
        ]));

        $this->info("INFO Observer [{$modelObserverPath} created successfully.");



        return 0;
    }


    protected function getRepositoryPath($repositoryClass)
    {
        return base_path('app/Repositories/' . class_basename($repositoryClass) . '.php');
    }

    protected function getModelCacheKeyPath($model)
    {
        return base_path('app/Cache/CacheKeys/' . class_basename($this->getQualifiedClass($model)) . 'CacheKeys.php');
    }

    protected function getModelObserverPath($model)
    {
        return base_path('app/Observers/' . class_basename($this->getQualifiedClass($model)) . 'Observer.php');
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

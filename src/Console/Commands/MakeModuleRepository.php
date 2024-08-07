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
        $repositoryPath = $this->getPath($repositoryClassName, $module);

        if (File::exists($repositoryPath)) {
            $this->error("Repository {$repositoryClassName} already exists!");
            return;
        }

        $this->makeDirectory($repositoryPath);

        file_put_contents($repositoryPath, strtr($stubs->repository, [
            '{{ repoNamespace }}' => 'Modules/'.$module.'/Repositories',
            '{{ class }}' => $repositoryClassName,
            '{{ modelNamespace }}' => $this->getQualifiedClass($model),
            '{{ model }}' => class_basename($this->getQualifiedClass($model))
        ]));

        
        $this->makeDirectory(base_path('Modules/'.$module.'/Cache/CacheKeys/' . class_basename($this->getQualifiedClass($model)) . 'CacheKeys.php'));

        file_put_contents(base_path('Modules/'.$module.'/Cache/CacheKeys/' . class_basename($this->getQualifiedClass($model)) . 'CacheKeys.php'), strtr($stubs->cachekeys,[
            '{{ class }}' => class_basename($this->getQualifiedClass($model)).'CacheKeys'
        ]));

        $this->info("Repository {$repositoryPath} created successfully.");

        return 0;
    }

    /**
     * Get repository path in the modules directory
     */
    protected function getPath($repositoryClassName, $module)
    {
        return base_path('Modules/'.$module.'/Repositories/'.class_basename($repositoryClassName) . '.php');
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

    protected function getStubs()
    {
        return new Any([
            'repository' => file_get_contents(__DIR__ . '/../../../stubs/repository.stub'),
            'cachekeys' => file_get_contents(__DIR__ . '/../../../stubs/cachekeys.stub')
        ]);
    }

    protected function getQualifiedClass($class)
    {
        return str_replace('/', '\\', $class);
    }
    
}

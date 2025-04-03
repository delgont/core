<?php

namespace Delgont\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ModuleMakeVueComponent extends Command
{
    protected $signature = 'module:make-vue {path} {--module= : The module where the Vue file should be created}';
    protected $description = 'Create a Vue component inside a specific Laravel module';

    public function handle()
    {
        $path = str_replace('\\', '/', $this->argument('path'));
        $module = $this->option('module') ?? $this->ask('Enter the module name');
        $fullPath = base_path("Modules/{$module}/Resources/assets/js/components/{$path}");

        if (!str_ends_with($fullPath, '.vue')) {
            $fullPath .= '.vue';
        }

        File::ensureDirectoryExists(dirname($fullPath));

        $componentName = pathinfo($fullPath, PATHINFO_FILENAME);
        $template = "<template>\n  <div>\n    <h1>{$componentName} Component</h1>\n  </div>\n</template>\n\n<script>\nexport default {\n  name: '{$componentName}'\n};\n</script>\n\n<style scoped>\nh1 { color: blue; }\n</style>";

        if (!File::exists($fullPath)) {
            File::put($fullPath, $template);
            $this->info("Vue component created in module {$module}: {$fullPath}");
        } else {
            $this->error("File already exists: {$fullPath}");
        }
    }
}

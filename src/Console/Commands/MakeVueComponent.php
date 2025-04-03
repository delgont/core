<?php

namespace Delgont\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeVueComponent extends Command
{
    protected $signature = 'make:vue {path}';
    protected $description = 'Create a Vue component in resources/js/components, supporting subdirectories';

    public function handle()
    {
        $path = str_replace('\\', '/', $this->argument('path'));
        $fullPath = base_path("resources/js/components/{$path}");

        if (!str_ends_with($fullPath, '.vue')) {
            $fullPath .= '.vue';
        }

        File::ensureDirectoryExists(dirname($fullPath));

        $componentName = pathinfo($fullPath, PATHINFO_FILENAME);
        $template = "<template>\n  <div>\n    <h1>{$componentName} Component</h1>\n  </div>\n</template>\n\n<script>\nexport default {\n  name: '{$componentName}'\n};\n</script>\n\n<style scoped>\nh1 { color: red; }\n</style>";

        if (!File::exists($fullPath)) {
            File::put($fullPath, $template);
            $this->info("Vue component created: {$fullPath}");
        } else {
            $this->error("File already exists: {$fullPath}");
        }
    }
}

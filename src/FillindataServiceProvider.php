<?php
/**
 * Created by PhpStorm.
 * User: vipda
 * Date: 2018/9/4
 * Time: 17:05
 */

namespace NoahProt\Fillindata;

use Illuminate\Support\ServiceProvider;

class FillindataServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $commandSource = __DIR__ . '/dataFill.php';

        $this->publishes([$commandSource => base_path('/app/Console/Commands/dataFill.php')]);

        if (!is_dir(resource_path('/csv/')))
            mkdir(resource_path('/csv/'));

        $this->loadCommands();
    }

    public function register()
    {
        
    }

    /**
     * @param string $path
     * @return $this
     */
    protected function loadCommands() {
        $kernelPath = base_path('app/Console/Kernel.php');
        $str=file_get_contents($kernelPath);

        if (!strpos($str, "dataFill::class,")) {
            $str=str_replace(
                'protected $commands = [',
                "protected \$commands = [\n\t\tdataFill::class,",
                $str);
        }

        if (!strpos($str, "use App\Console\Commands\dataFill;")){
            $str=str_replace(
                'namespace App\Console;',
                "namespace App\Console;\nuse App\Console\Commands\dataFill;",
                $str);
        }

        file_put_contents($kernelPath, $str);
    }
}


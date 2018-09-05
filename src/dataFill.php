<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dataFill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "fill:data {modelName}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fill in data to the specific table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $modelName = $this->argument('modelName');
        $model = $this->getModelByName($modelName);

        $CSVFile = resource_path('csv/'.$model->getTable().'.csv');

        if (!file_exists($CSVFile) || ! is_readable($CSVFile))
            return false;

        $header  = null;
        $data = array();

        if (($handle = fopen($CSVFile, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                    // 去除fgetcsv产生的bug
                    foreach ($header as $index => $item) {
                        $header[$index] = preg_replace('/[^\da-z.]/i', '', $item);
                    }
                }else {
                    $data[] = array_combine($header, $row);
                }
            }

            fclose($handle);

        }

        $dataCount = count($data);

        for ($i = 0; $i < $dataCount; $i ++ ){
            $model::firstOrCreate($data[$i]);
        }
        echo "Filled in table {$model->getTable()} Success!"."\n";
    }

    public function getModelByName($modelName){
        $modelSpace = 'App\\'.studly_case(strtolower(str_singular($modelName)));
        return new $modelSpace;
    }
}

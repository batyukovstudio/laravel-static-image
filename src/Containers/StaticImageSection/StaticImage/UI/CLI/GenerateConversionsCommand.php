<?php

namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\UI\CLI;

use Illuminate\Console\Command;

class GenerateConversionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-static-image:generate-conversions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     *
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function handle()
    {
        $result = exec('npm run static-image:generate', $output);
        foreach ($output as $item) {
            print_r($item . PHP_EOL);
        }
    }
}

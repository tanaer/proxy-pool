<?php

namespace App\Console\Commands;

use App\Spiders\Spider;
use Illuminate\Console\Command;

class ProxyCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:crawl {drivers?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Proxy';

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
        if ($drivers = $this->argument('drivers')) {
            $drivers = explode('|', $drivers);
        }else{
            $drivers_path = app_path('Spiders/Drivers');
            $drivers = array_values(array_diff(scandir($drivers_path), array('..', '.')));
            array_walk($drivers,function (&$driver){
                $driver = substr($driver,0,strpos($driver,'.'));
            });
        }
        $spider = Spider::getInstance();
        foreach ($drivers as $driver) {
            $spider->setDriver($driver);
            $spider->handle();
        }
    }
}

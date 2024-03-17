<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class mysqldump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump the MySql database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dbhost = env('DB_HOST');
        $dbport = env('DB_PORT');
        $dbname = env('DB_DATABASE');
        $dbuser = env('DB_USERNAME');
        $dbpass = env('DB_PASSWORD');

        $dbfile = $dbname . '-' . date('Y-m-d') . '.sql.gz';

        $mysql_command = "mysqldump -v -u{$dbuser} -h{$dbhost} -p{$dbpass}   {$dbname} >  $dbfile";

        system($mysql_command);

        return 0;
    }
}

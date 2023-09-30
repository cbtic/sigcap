<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use JeroenZwart\CsvSeeder\CsvSeeder;
use DB;

class UbigeoSeeder extends CsvSeeder
{
    public function __construct(){
        $this->file = '/database/seeders/csv/ubigeos.csv';
		$this->encode = false;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::disableQueryLog();
	    parent::run();
    }
}

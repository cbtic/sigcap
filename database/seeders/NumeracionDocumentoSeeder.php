<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use JeroenZwart\CsvSeeder\CsvSeeder;
use DB;


class NumeracionDocumentoSeeder extends CsvSeeder
{
    public function __construct(){
        $this->file = '/database/seeders/csv/numeracion_documentos.csv';
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
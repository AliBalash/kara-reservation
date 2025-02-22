<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DiscountCodesImport;

class ImportDiscountCodes extends Command
{
    protected $signature = 'import:discount-codes {file}';
    protected $description = 'Import discount codes from an Excel file';

    public function handle()
    {
        $file = $this->argument('file');
        Excel::import(new DiscountCodesImport, $file);
        $this->info('Discount codes imported successfully!');
    }
}

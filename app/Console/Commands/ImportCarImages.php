<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarModel;

class ImportCarImages extends Command
{
    protected $signature = 'import:car-images';
    protected $description = 'Import car images and link them to car models';

    public function handle()
    {
        $directory = public_path('/assets/car-pics'); // مسیر فولدر تصاویر
        $files = scandir($directory);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'webp' && pathinfo($file, PATHINFO_EXTENSION) !== 'png') {
                continue; // فقط فایل‌های با فرمت webp و png را پردازش کن
            }

            // استخراج نام مدل خودرو از نام فایل
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            // فرض کنیم نام فایل فقط شامل مدل ماشین است، مثلا 'AUDI-A6-' یا 'Kia-sonet-'
            // در اینجا فقط اسامی مدل‌ها استخراج می‌کنیم و سال را حذف می‌کنیم
            $car = explode(' ', $fileName); // حذف اعداد و خط تیره‌ها
            if(count($car) <=1 ){
            $car = explode('-', $fileName); // حذف اعداد و خط تیره‌ها

            }
            var_dump($car);

            var_dump($fileName);
            $brandName = trim($car[0]); // تبدیل خط تیره‌ها به فاصله برای مطابقت بهتر با مدل‌ها
            $modelName = trim($car[1]); // تبدیل خط تیره‌ها به فاصله برای مطابقت بهتر با مدل‌ها

            $this->warn("Car brand: $brandName");
            $this->warn("Car model: $modelName");

            // جستجوی مدل خودرو در دیتابیس
            $carModel = CarModel::where('model', 'LIKE', "%$modelName%")
                ->first();

            if (!$carModel) {
                $this->warn("Car model not found for: $file");
                continue;
            }

            // ذخیره تصویر
            $carModel->images()->create([
                'file_path' => 'car-pics/',
                'file_name' => $file,
            ]);

            $this->info("Image added for: {$carModel->model}");
        }

        $this->info('Image import completed!');
    }
}

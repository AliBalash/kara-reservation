<?php

namespace App\Imports;

use App\Models\DiscountCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscountCodesImport implements ToModel
{
    public function model(array $row)
    {
        if (empty($row[0]) || empty($row[1])) {
            return null;
        }

        $formattedPhone = $this->fixPhoneNumber($row[1]);

        if (DiscountCode::where('phone', $formattedPhone)->exists()) {
            return null;
        }

        return new DiscountCode([
            'name' => $row[0],
            'phone' => $formattedPhone, // Shomare tabdil shode
            'code' => DiscountCode::generateCode(),
            'discount_percentage' => 10,
        ]);
    }

    private function fixPhoneNumber($phone)
    {
        // Pak kardan space ya karakter haye ezafe
        $phone = preg_replace('/\D/', '', $phone);

        // Code haye keshvar hayi ke darim
        $countryCodes = [
            '98'  => '+98',  // Iran
            '965' => '+965', // Kuwait
            '90'  => '+90',  // Turkey
            '971' => '+971', // UAE
        ];

        foreach ($countryCodes as $prefix => $formattedPrefix) {
            if (strpos($phone, $prefix) === 0) {
                return $formattedPrefix . substr($phone, strlen($prefix));
            }
        }

        // Agar code keshvar nadasht, shomare ra bar asas Iran (+98) gharar mide
        return '+98' . ltrim($phone, '0');
    }
}

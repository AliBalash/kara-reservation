<?php

namespace App\Imports;

use App\Models\DiscountCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscountCodesImport implements ToModel
{
  

    public function model(array $row)
    {

        // Agar name ya phone NULL bashe, skip kon
        if (empty($row[0]) || empty($row[1])) {
            return null;
        }

        // Check mikonim ke phone tekrari nabashe
        if (DiscountCode::where('phone', $row[1])->exists()) {
            return null;
        }
        return new DiscountCode([
            'name' => $row[0],
            'phone' => $this->fixPhoneNumber($row[1]), // Taghir dadan shomare
            'code' => DiscountCode::generateCode(),
            'discount_percentage' => 5,
        ]);
    }

    private function fixPhoneNumber($phone)
    {
        return preg_replace('/^98/', '0', $phone); // Taghir format
    }
}

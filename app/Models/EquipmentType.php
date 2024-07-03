<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    public function IsSeriesMatchMask(string $series_number): bool
    {
        if (strlen($series_number) != strlen($this->mask))
            return false;

        $regx = array(
            "N" => "[0-9]",
            "A" => "[A-Z]",
            "a" => "[a-z]",
            "X" => "[A-Z0-9]",
            "Z" => "[-|_|@]"
        );

        $maskChars = str_split($this->mask);

        $outputRegex = "/^";
        foreach ($maskChars as $char) {
            $outputRegex .= $regx[$char];
        }
        $outputRegex .= "/";

        return (preg_match($outputRegex, $series_number) > 0 ? true: false);
    }
}

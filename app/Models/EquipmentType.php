<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


/**
 * @method static Builder|Equipment query()
 * @method static Builder|Equipment where()
 * @property bool IsSeriesMatchMask($value)
 * @property string mask
 */
class EquipmentType extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Checks $series_number against the mask of the current EquipmentType.
     * @param string $series_number
     * @return bool
     */
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

        return preg_match($outputRegex, $series_number) > 0;
    }
}

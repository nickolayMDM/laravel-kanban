<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Column extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function move($toIndex, $fromIndex)
    {
        $column = self::where('index', $fromIndex)->first();
        $column->index = $toIndex;
        $column->save();

        self::where('id', '<>', $column['id'])->where('index', '>=', $fromIndex)->update(['index' => DB::raw('`index` - 1')]);
        self::where('id', '<>', $column['id'])->where('index', '>=', $toIndex)->update(['index' => DB::raw('`index` + 1')]);
    }

    public static function convertColumnsForFrontend($columns)
    {
        $result = [];

        foreach ($columns as $column) {
            $result[] = [
                'name' => $column['name'],
                'cards' => (isset($column['cards'])) ? $column['cards'] : []
            ];
        }

        return $result;
    }
}

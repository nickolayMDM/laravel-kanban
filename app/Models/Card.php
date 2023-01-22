<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function populateColumns($columns)
    {
        $cards = Card::select('name', 'description', 'index', 'column_id')
            ->orderBy('index')
            ->get()->toArray();

        foreach ($cards as $card) {
            if (!isset($columns[intval($card["column_id"])])) {
                continue;
            }
            if (!isset($columns[intval($card["column_id"])]['cards'])) {
                $columns[intval($card["column_id"])]['cards'] = [];
            }

            $columns[intval($card["column_id"])]['cards'][] = [
                'name' => $card['name'],
                'description' => $card['description'],
            ];
        }

        return $columns;
    }

    public static function move($toIndex, $fromIndex, $toColumnIndex, $fromColumnIndex)
    {
        $toColumn = Column::where('index', $toColumnIndex)->first();
        if ($fromColumnIndex != $toColumnIndex) {
            $fromColumn = Column::where('index', $fromColumnIndex)->first();
        } else {
            $fromColumn = $toColumn;
        }
        $card = Card::where('index', $fromIndex)
            ->where('column_id', $fromColumn['id'])
            ->first();

        $card->index = $toIndex;
        $card->column_id = $toColumn['id'];
        $card->save();

        self::where('id', '<>', $card['id'])->where('column_id', $fromColumn['id'])->where('index', '>=', $fromIndex)->update(['index' => DB::raw('`index` - 1')]);
        self::where('id', '<>', $card['id'])->where('column_id', $toColumn['id'])->where('index', '>=', $toIndex)->update(['index' => DB::raw('`index` + 1')]);
    }
}

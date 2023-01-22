<?php

namespace App\Http\Controllers\Api;

use App\Models\Board;
use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Spatie\DbDumper\Databases\MySql as MysqlDumper;

class ColumnController extends BaseController
{
    public function getState ()
    {
        $columns = Column::select('id', 'name')
            ->orderBy('index')
            ->get()->keyBy('id')->toArray();
        $columnsWithCards = Card::populateColumns($columns);
        $convertedColumns = Column::convertColumnsForFrontend($columnsWithCards);

        return response()->json([
            'columns' => $convertedColumns
        ]);
    }

    public function dumpState ()
    {
        MysqlDumper::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile('dump.sql');

        return response()->json([
            'redirect' => '/sql'
        ]);
    }

    public function postColumn (Request $request)
    {
        $name = $request->input('name');
        $index = $request->input('index');
        $boardCookieId = $request->cookie(Board::cookieName);

        $column = new Column;
        $column->name = $name;
        $column->index = $index;
        $column->board_id = $boardCookieId;
        $column->save();
    }

    public function editColumn (Request $request)
    {
        $name = $request->input('name');
        $index = $request->input('index');
        $boardCookieId = $request->cookie(Board::cookieName);

        $card = Column::where('index', $index)
            ->where('board_id', $boardCookieId)
            ->first();
        $card->name = $name;
        $card->save();
    }

    public function moveColumn (Request $request)
    {
        $index = $request->input('index');
        $oldIndex = $request->input('oldIndex');

        Column::move($index, $oldIndex);
    }

    public function deleteColumn (Request $request)
    {
        $index = $request->input('index');

        $column = Column::where('index', $index)->first();

        Card::where('column_id', $column['id'])->delete();

        $columnsWithGreaterIndex = Column::where('index', '>', $index)->get();
        foreach ($columnsWithGreaterIndex as $columnWithGreaterIndex) {
            $columnWithGreaterIndex['index'] = $columnWithGreaterIndex['index'] - 1;
            $columnWithGreaterIndex->save();
        }

        $column->delete();
    }
}

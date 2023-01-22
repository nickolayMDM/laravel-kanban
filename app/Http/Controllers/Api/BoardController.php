<?php

namespace App\Http\Controllers\Api;

use App\Models\Board;
use App\Models\Column;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Spatie\DbDumper\Databases\MySql as MysqlDumper;

class BoardController extends BaseController
{
    public function get (Request $request)
    {
        $boardCookieId = $request->cookie(Board::cookieName);
        if (!$boardCookieId) {
            return response()->status(404)->json(["error" => "board could not be found"]);
        }

        $columns = Column::select('id', 'name')
            ->where('board_id', $boardCookieId)
            ->orderBy('index')
            ->get()->keyBy('id')->toArray();
        $columnsWithCards = Card::populateColumns($columns);
        $convertedColumns = Column::convertColumnsForFrontend($columnsWithCards);

        return response()->json([
            'columns' => $convertedColumns
        ]);
    }
}

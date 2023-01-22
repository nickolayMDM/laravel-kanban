<?php

namespace App\Http\Controllers\Api;

use App\Models\Column;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CardController extends BaseController
{
    public function listCards (Request $request)
    {
        $createdAt = $request->input('date');
        $status = $request->input('status');

        $cardsQuery = Card::select("*");

        if ($status == "0") {
            $cardsQuery->onlyTrashed();
        } else if ($status != "1") {
            $cardsQuery->withTrashed();
        }

        if ($createdAt) {
            $cardsQuery->whereDate("created_at", "=", date($createdAt));
        }

        $cards = $cardsQuery->get();

        return response()->json([
            compact('cards')
        ]);
    }

    public function postCard (Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description') ?? "";
        $index = $request->input('index');
        $columnIndex = $request->input('columnIndex');

        $column = Column::where('index', $columnIndex)->first();

        $card = new Card();
        $card->name = $name;
        $card->description = $description;
        $card->index = $index;
        $card->column_id = $column['id'];
        $card->save();
    }

    public function editCard (Request $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $index = $request->input('index');
        $columnIndex = $request->input('columnIndex');

        $column = Column::where('index', $columnIndex)->first();

        $card = Card::where('index', $index)
            ->where('column_id', $column['id'])
            ->first();
        $card->name = $name;
        $card->description = $description;
        $card->save();
    }

    public function moveCard (Request $request)
    {
        $oldIndex = $request->input('oldIndex');
        $oldColumnIndex = $request->input('oldColumnIndex');
        $index = $request->input('index');
        $columnIndex = $request->input('columnIndex');

        Card::move($index, $oldIndex, $columnIndex, $oldColumnIndex);
    }

    public function deleteCard (Request $request)
    {
        $index = $request->input('index');
        $columnIndex = $request->input('columnIndex');

        $column = Column::where('index', $columnIndex)->first();
        Card::where('index', $index)
            ->where('column_id', $column['id'])
            ->delete();

        $cardsWithGreaterIndex = Card::where('index', '>', $index)
            ->where('column_id', $column['id'])
            ->get();
        foreach ($cardsWithGreaterIndex as $cardWithGreaterIndex) {
            $cardWithGreaterIndex['index'] = $cardWithGreaterIndex['index'] - 1;
            $cardWithGreaterIndex->save();
        }
    }
}

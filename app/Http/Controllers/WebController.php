<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;

class WebController extends BaseController
{
    public function index (Request $request)
    {
        $response = false;
        $board = false;

        $boardCookieId = $request->cookie(Board::cookieName);
        if ($boardCookieId) {
            $board = Board::where('id', $boardCookieId)->first();

            $response = Response(view("index", [
                'boardHash' => $board->hash
            ]));
        }

        if (!$board) {
            $board = Board::generate();
            $cookie = $board->makeCookie();

            $response = Response(view("index", [
                'boardHash' => $board->hash
            ]))
                ->withCookie($cookie);
        }

        return $response;
    }

    public function getSql ()
    {
        $dump = File::get("dump.sql");

        return view("sql", [
            "dump" => $dump
        ]);
    }
}

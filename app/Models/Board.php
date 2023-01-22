<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class Board extends Model
{
    use HasFactory;
    use SoftDeletes;

    const cookieName = "board";
    const hashCookieTimeMin = 60*24*30;

    public static function generate()
    {
        $board = new self();
        $board->hash = Hash::make('');
        $board->save();

        $board->hash = Hash::make($board->id);
        $board->save();

        return $board;
    }

    public static function getbyHash($hash)
    {
        $board = self::where("hash", $hash)->first();

        if (!$board) {
            return false;
        }

        return $board;
    }

    public function makeCookie()
    {
        return Cookie::make(self::cookieName, $this->id, self::hashCookieTimeMin);
    }
}

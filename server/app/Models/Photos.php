<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\User;

class Photos extends BaseModel
{
    /**
     * 公開範囲が無制限の写真を全て取得
     *
     * @return object|null
     */
    public function getDataDescId()
    {
        return self::orderBy('id', 'DESC')->get();
    }

    /**
     * 写真単体データを取得
     *
     * @param integer $id
     * @return object|null
     */
    public function getDataById($id)
    {
        // withでUsersテーブルの内容をまとめて取得
        return self::with('user')->find($id);
    }

    /**
     * Usersテーブルとリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 論理削除
     *
     * @param integer $id
     * @return boolean
     */
    public function softDeleteById($id)
    {
        return self::find($id)->delete();
    }

    // public function deleteById($id)
    // {
    //     // 物理削除はforceDelete()
    //     self::find($id)->forceDelete();
    // }

    /**
     * upsert処理
     *
     * @param array $upsertData
     * @param array $priKey
     * @return integer
     */
    public function upsertData($upsertData, $priKey)
    {
        return self::upsert($upsertData, $priKey);
    }

    public function upsertDataColumns($upsertData, $priKey, $columns)
    {
        return self::upsert($upsertData, $priKey, $columns);
    }
}

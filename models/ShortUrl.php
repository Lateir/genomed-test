<?php
namespace app\models;

use yii\db\ActiveRecord;

class ShortUrl extends ActiveRecord
{
    public static function tableName() { return 'short_url'; }

    public function rules()
    {
        return [
            [['original_url', 'short_code'], 'required'],
            ['original_url', 'url'],
            ['short_code', 'unique'],
        ];
    }

    public function getLogs()
    {
        return $this->hasMany(UrlClickLog::class, ['short_url_id' => 'id']);
    }
}
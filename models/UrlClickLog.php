<?php
namespace app\models;

use yii\db\ActiveRecord;

class UrlClickLog extends ActiveRecord
{
    public static function tableName() { return 'url_click_log'; }

    public function rules()
    {
        return [
            [['short_url_id', 'ip_address'], 'required'],
            ['ip_address', 'ip']
        ];
    }
}
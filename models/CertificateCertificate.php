<?php

namespace usesgraphcrt\certificate\models;

use Yii;

/**
 * This is the model class for table "certificate_certificate".
 *
 * @property integer $id
 * @property string $code
 * @property string $type
 * @property string $created_at
 * @property string $date_elapsed
 * @property string $status
 * @property integer $owner_id
 */
class CertificateCertificate extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'certificate_certificate';
    }

    public function rules()
    {
        return [
            [['type', 'created_at', 'status', 'owner_id'], 'required'],
            [['type', 'status'], 'string'],
            [['created_at', 'date_elapsed'], 'safe'],
            [['owner_id', 'target_user'], 'integer'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'type' => 'Тип сертификата',
            'created_at' => 'Дата создания',
            'date_elapsed' => 'Срок истечения',
            'status' => 'Статус сертификата',
            'owner_id' => 'Создал сертификат',
            'target_user' => 'Владелец сертификата',
        ];
    }
    
}

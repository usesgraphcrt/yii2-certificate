<?php

namespace usesgraphcrt\certificate\models;

use Yii;

class Certificate extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'certificate_certificate';
    }

    public function rules()
    {
        return [
            [['type', 'created_at', 'status', 'owner_id'], 'required'],
            [['type', 'status', 'employment'], 'string'],
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
            'employment' => 'Тип использования',
            'created_at' => 'Дата создания',
            'date_elapsed' => 'Срок истечения',
            'status' => 'Статус сертификата',
            'owner_id' => 'Создал сертификат',
            'target_user' => 'Владелец сертификата',
        ];
    }

    public function getTargetUser()
    {
        $userModel = \Yii::$app->getModule('certificate')->clientModel;
        $userModel = new $userModel;
        $user = $userModel::findOne(['id'=> $this->target_user]);
        return $user->name;
    }

    public function getTargetModels()
    {
        return $this->hasMany(CertificateToItem::className(), ['certificate_id' => 'id']);
    }
    
}

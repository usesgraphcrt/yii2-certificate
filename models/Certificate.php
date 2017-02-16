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
            [['created_at', 'owner_id'], 'required'],
            [['type'],'required','message' => 'Необходимо выбрать тип сертификата.'],
            [['status'],'required','message' => 'Необходимо выбрать статус сертификата.'],
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
            'code' => 'Код',
            'type' => 'Тип сертификата',
            'employment' => 'Тип использования',
            'created_at' => 'Дата создания',
            'date_elapsed' => 'Срок истечения',
            'status' => 'Статус сертификата',
            'owner_id' => 'Создал сертификат',
            'target_user' => 'Клиент',
        ];
    }

    public function getTargetUser()
    {
        $userModel = \Yii::$app->getModule('certificate')->clientModel;
        $userModel = new $userModel;
        $user = $userModel::findOne(['id'=> $this->target_user]);
        
        if($user = $userModel::findOne(['id'=> $this->target_user])) {
            return $user->name;
        } else {
            return null;
        }
    }

    public function getTargetModels()
    {
        return $this->hasMany(CertificateToItem::className(), ['certificate_id' => 'id']);
    }

    public function getTransactions()
    {
        return $this->hasMany(CertificateUse::className(),['certificate_id' => 'id']);
    }
    
}

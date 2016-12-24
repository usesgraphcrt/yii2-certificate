<?php

namespace usesgraphcrt\certificate\models;

use Yii;


class CertificateToItem extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'certificate_certificate_to_item';
    }
    
    public function rules()
    {
        return [
            [['certificate_id', 'target_model'], 'required'],
            [['certificate_id', 'target_id', 'amount'], 'integer'],
            [['target_model'], 'string', 'max' => 500],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'certificate_id' => 'Certificate ID',
            'target_model' => 'Target Model',
            'target_id' => 'Target ID',
            'amount' => 'Amount',
        ];
    }
}

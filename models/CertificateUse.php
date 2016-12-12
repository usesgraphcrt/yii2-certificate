<?php

namespace usesgraphcrt\certificate\models;

use Yii;

/**
 * This is the model class for table "certificate_use".
 *
 * @property integer $id
 * @property integer $certificate_id
 * @property string $date
 * @property string $amount
 * @property string $balance
 */
class CertificateUse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certificate_use';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['certificate_id', 'date', 'amount', 'balance'], 'required'],
            [['certificate_id'], 'integer'],
            [['date'], 'safe'],
            [['amount', 'balance'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'certificate_id' => 'Certificate ID',
            'date' => 'Date',
            'amount' => 'Amount',
            'balance' => 'Balance',
        ];
    }
}

<?php

namespace usesgraphcrt\certificate\models;

use Yii;

/**
 * This is the model class for table "certificate_certificate_to_item".
 *
 * @property integer $id
 * @property integer $certificate_id
 * @property string $target_model
 * @property integer $target_id
 * @property integer $amount
 */
class CertificateCertificateToItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certificate_certificate_to_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['certificate_id', 'target_model'], 'required'],
            [['certificate_id', 'target_id', 'amount'], 'integer'],
            [['target_model'], 'string', 'max' => 500],
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
            'target_model' => 'Target Model',
            'target_id' => 'Target ID',
            'amount' => 'Amount',
        ];
    }
}

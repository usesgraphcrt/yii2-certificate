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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certificate_certificate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'type', 'created_at', 'status', 'owner_id'], 'required'],
            [['type', 'status'], 'string'],
            [['created_at', 'date_elapsed'], 'safe'],
            [['owner_id'], 'integer'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'type' => 'Type',
            'created_at' => 'Created At',
            'date_elapsed' => 'Date Elapsed',
            'status' => 'Status',
            'owner_id' => 'Owner ID',
        ];
    }
}

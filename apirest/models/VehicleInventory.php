<?php

namespace apirest\models;


/**
 * This is the model class for table "vehicle_inventory".
 *
 * @property integer $id
 * @property integer $vehicle_id
 * @property integer $amount
 * @property string $updated_at
 *
 */
class VehicleInventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicle_id', 'amount'], 'required'],
            [['vehicle_id', 'amount'], 'integer']
        ];
    }

}



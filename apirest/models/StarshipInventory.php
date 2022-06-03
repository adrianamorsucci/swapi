<?php

namespace apirest\models;


/**
 * This is the model class for table "starship_inventory".
 *
 * @property integer $id
 * @property integer $starship_id
 * @property integer $amount
 * @property string $updated_at
 *
 */
class StarshipInventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'starship_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['starship_id', 'amount'], 'required'],
            [['starship_id', 'amount'], 'integer']
        ];
    }

}



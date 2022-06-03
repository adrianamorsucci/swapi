<?php


namespace apirest\controllers;

use Yii;
use yii\rest\Controller;
use apirest\models\VehicleInventory;


class VehicleController extends Controller
{

    /**
     * Lists all Vehicles.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $resource = isset($params['resource']) ? $params['resource'] : Yii::$app->params['base_url'] . "vehicles";
        $datos = json_decode(Yii::$app->curlClient->get($resource), true);


        foreach ($datos['results'] as $i => $dato) 
        {
            // esto se puede optimizar obteniendo primero todos los ids y luego buscando con 1 unico acceso a la db
            $id = str_replace('/', '', substr($dato['url'], strrpos($dato['url'], '/', -2)));
            $inventory = VehicleInventory::find()->where(['vehicle_id'=>$id])->one();
            
            $datos['results'][$i]['count'] = ($inventory) ? $inventory->amount : null;
        }

        return $datos;
    }

    /**
     * Displays a single Vehicle model.
     * @param int $id The id of the vehicle to be displayed
     * @return mixed
     */
    public function actionView($id)
    {
        $resource = Yii::$app->params['base_url'] . "vehicles/$id";
        $datos = json_decode(Yii::$app->curlClient->get($resource), true);

        $inventory = VehicleInventory::find()->where(['vehicle_id'=>$id])->one();
        $datos['count'] = ($inventory) ? $inventory->amount : null;

        return $datos;
    }

    /**
     * Updates the number of units in inventory for a single vehicle.
     * @param int $id The id of the vehicle to be updated
     * @param int $amount The number of units to update the inventory
     * @param string $action Must be one of the following: 
     *                       - set (sets de number of units indicated by $amount), 
     *                       - add (add the number of units indicated by $amount),  
     *                       - sub (subtract the number of units indicated by $amount)
     * @return mixed If success, the updated inventory information will be displayed, 
     *               otherwise, an error message will be displayed.
     * @example 
     * curl --location --request POST 'http://localhost/vehicles/20' \
     *       --header 'Content-Type: application/json' \
     *       --data-raw '{
     *           "action": "set",
     *           "amount": 2
     *       }'
     * 
     */
    public function actionUpdate($id)
    {
        $params = Yii::$app->request->post();
        $result = [];

        // obtener el inventario 
        $inventory = VehicleInventory::find()->where(['vehicle_id'=>$id])->one();
        if (!$inventory) 
        {
            $inventory = new VehicleInventory();
            $inventory->vehicle_id = $id;
        }

        // validaciones
        $errors = [];
        if (!isset($params['action'])) 
        {
            $errors[] = "The 'action' field is required";
        }
        elseif (!in_array($params['action'], ['set', 'add', 'sub']))  
        {
            $errors[] = "The 'action' field must be one of the following values: 'set', 'add' or 'sub'";
        }

        if (!isset($params['amount'])) 
        {
            $errors[] = "The 'amount' field is required";
        }
        elseif ($params['amount']<=0) // validar tmb que sea entero 
        {
            $errors[] = "The 'amount' field must be greater than zero";
        }
        elseif (isset($params['action']) && $params['action']=='sub' && $params['amount']>$inventory->amount) 
        {
            $errors[] = "The quantity to be decreased exceeds the existence of the inventory. Current Units: ".$inventory->amount;
        }



        $inventory->updated_at = date('Y-m-d H:i:s');

        switch ($params['action']) 
        {
            case 'add':
                // incrementa el numero de unidades
                $inventory->amount = $inventory->amount + $params['amount'];
                break;
            
            case 'sub':
                // decrementa el numero de unidades
                $inventory->amount = $inventory->amount - $params['amount'];
                break;
            
            case 'set':
                // setea el numero de unidades
                $inventory->amount = $params['amount'];
                break;
            
            default:
                // code...
                break;
        }

        if (count($errors)==0 && $inventory->save()) 
        {
            $result['count'] = $inventory->amount;
        }

        return count($errors)>0? $errors : $result;

    }

}

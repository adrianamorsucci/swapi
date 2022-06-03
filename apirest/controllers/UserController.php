<?php

namespace apirest\controllers;
 
use Yii;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\UnauthorizedHttpException;
use apirest\models\LoginForm;
use apirest\models\User;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;


class UserController extends Controller
{
    public $modelClass = 'apirest\models\User';
    

    function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class'=> QueryParamAuth:: className (), // Implementing access token authentication
                'except'=> ['login'], 
            ]
        ]);
    }

    public function actionIndex()
    {
        $query = User::find();
    
        return new ActiveDataProvider([
            'query' => $query, 
            'pagination' => false,
        ]);
    }
    

    public function actionView($id)
    {
        $user = User::find()->where(['id'=>$id])->one();
        
        if (!$user) 
        {
            throw new NotFoundHttpException('The requested User was not found.');
        }

        return $user; 
    }


    public function actionCreate()
    {

        $params = Yii::$app->request->post();

        $model = new User();
        if ($model->load($params, '') && $result = $model->signup()) 
        {
            return $result;
        } 
        else 
        {
            return $model->getErrors();
        }
    }

    public function actionLogin()
    {

        $params = Yii::$app->request->post();

        //print_r($params); exit();

        $model = new LoginForm();
        if ($model->load($params, '') && $result = $model->login()) 
        {
            return $result;
        } 
        else 
        {
            return $model->getErrors();
        }
    }

}
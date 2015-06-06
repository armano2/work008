<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

use app\models\gii\Contact;


class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'contact_list', 'contact_remove'],
                'ruleConfig' => [
                    'class' => 'app\models\AccessRule'
                ],
                'rules' => [
                    [
                        'actions' => ['index', 'contact_list', 'contact_remove'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionContact_list()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Contact::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $posts = $dataProvider->getModels();
        return $this->render('contact_list', ['dataProvider' => $dataProvider]);
    }

    public function actionContact_remove()
    {
        $id = Yii::$app->getRequest()->getQueryParam('id');
        if (is_numeric($id) && $id > 0) {
            Contact::deleteAll('id = :id', [':id' => $id]);
        }

        return $this->redirect(['/admin/contact_list'], 302);
    }
}

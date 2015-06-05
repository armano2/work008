<?php
namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionIndex()
    {
        $user = new User();
        $user->email = 'admin@example.com';
        $user->setPassword('zxc123');
        $user->generateAuthKey();
        $user->save();

        $auth = Yii::$app->authManager;

        // add "user" permission
        $user = $auth->createPermission('user');
        $user->description = 'User Premission';
        $auth->add($user);

        // add "example" role and give this role the "user" permission
        $author = $auth->createRole('example');
        $author->description = 'Example Premission';
        $auth->add($author);
        $auth->addChild($author, $user);

        // add "admin" role and give this role the "example" permission
        // as well as the permissions of the "user" role
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin Premission';
        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $author);

        // Set user 1 as admin
        $auth->assign($admin, 1);
    }
}
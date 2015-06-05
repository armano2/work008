<?php

namespace app\models;

use Yii;
use yii\filters\AccessRule as GenericAccessRule;

class AccessRule extends GenericAccessRule
{
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role == '?' && $user->isGuest) {
                return true;
            }
            if ($role == '@' && !$user->isGuest) {
                return true;
            }
            if (Yii::$app->authManager->checkAccess($user->identity->id, $role)) {
                return true;
            }
        }
        return false;
    }
}

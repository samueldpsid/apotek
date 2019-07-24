<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Manajemen extends Component {

    public function getPenugasan($id = 0) {
        if ($id==0) $id = Yii::$app->user->getId();
        $value = Yii::$app->authManager->getRolesByUser($id);
        return isset(end($value)->name) ? end($value)->name : 'Guest';
    }
}

?>

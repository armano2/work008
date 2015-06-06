<?php
use yii\widgets\DetailView;
?>

<?php var_dump($model)?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'user_id',
        'message:ntext',
    ],
]) ?>

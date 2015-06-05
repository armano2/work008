<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContactForm */
/* @var $form ActiveForm */
?>
<div class="site-contact">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'body') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-contact -->

<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Example Page';
?>
<div class="site-index">
    <div class="body-content">
        <?= Html::a('List of all contacts', ['/admin/contact_list'], ['class'=>'btn btn-primary']) ?>
    </div>
</div>

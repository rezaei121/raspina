<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="direction: ltr"><?= $this->title ?></div>
        <div class="panel-body">

<div class="site-error">

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
</div>

        </div>
    </div>
</div>


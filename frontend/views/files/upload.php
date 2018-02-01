<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UploadFileForm */

?>

<?php
// TODO: створити віджет і систему flash повідомлень для зручного використання цього віджету
if (Yii::$app->getSession()->hasFlash('fileUploadingErrors')):
    echo Alert::widget([
        'options' => ['class' => 'alert-info'],
        'body' => Yii::$app->session->getFlash('fileUploadingErrors'),
    ]);
endif;
?>

<?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'action' => ['files/upload-post']
]) ?>

<?= $form->field($model, 'file_name')->fileInput() ?>

    <button>Upload</button>

<?php ActiveForm::end() ?>
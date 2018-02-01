<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\FilesSearch */

$this->title = 'Files list';

?>

<?php
    // TODO: створити віджет і систему flash повідомлень для зручного використання цього віджету
    if (Yii::$app->getSession()->hasFlash('fileUploaded')):
        echo Alert::widget([
            'options' => ['class' => 'alert-info'],
            'body' => Yii::$app->session->getFlash('fileUploaded'),
        ]);
    endif;
?>



<?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Username',
                'value' => function ($data) {
                    /** @var $data app\models\FileRecord */
                    return $data->user->username;
                },
            ],
            [
                'label' => 'File Name',
                'value' => function ($data) {
                    return Html::a($data['file_name'], "uploads/" . $data['file_name']); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'html',
            ],
            'created_at:datetime',
        ],
    ])
?>
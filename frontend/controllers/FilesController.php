<?php

namespace frontend\controllers;

use app\models\FilesSearch;
use app\models\UploadFileForm;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use Yii;
use app\models\FileRecord;

/**
 * Class FilesController
 * @package frontend\controllers
 */
class FilesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['upload', 'upload-post'],
                'rules' => [
                    [
                        'actions' => ['upload', 'upload-post'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload-post' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays Grid view widget with list of Uploaded Files.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FilesSearch();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(Yii::$app->request->get())
        ]);
    }

    /**
     * Uploading form
     *
     * @return string
     */
    public function actionUpload()
    {
        $model = new UploadFileForm();

        return $this->render('upload', ['model' => $model]);

    }

    /**
     * Uploads file
     * Uploads Uploaded File to permanent directory and creates corresponding record in DB
     *
     * @return \yii\web\Response
     */
    public function actionUploadPost()
    {
        $model = new UploadFileForm();
        $model->file_name = UploadedFile::getInstance($model, 'file_name');


        if (!$model->upload()) {
            Yii::$app->getSession()->setFlash('fileUploadingErrors', 'Something went wrong please call technical support.');
            return $this->redirect(['files/upload']);
        }

        $fileRecord = new FileRecord();
        $fileRecord->file_name = $model->new_file_name;
        $fileRecord->user_id = Yii::$app->getUser()->getId();
        $fileRecord->save();
        Yii::$app->getSession()->setFlash('fileUploaded', 'You have successfully uploaded your file.');

        return $this->redirect(['files/index']);
    }
}

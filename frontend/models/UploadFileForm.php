<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadFileForm
 * @package app\models
 */
class UploadFileForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file_name;

    /**
     * Actually file name that uploaded to directory
     *
     * @var string
     */
    public $new_file_name;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['file_name'], 'file', 'skipOnEmpty' => false],
        ];
    }

    /**
     * Uploads uploaded file to permanent directory
     *
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->new_file_name = uniqid() . '.' .  $this->file_name->extension;
            $this->file_name->saveAs('uploads/' . $this->new_file_name);
            return true;
        } else {
            return false;
        }
    }
}

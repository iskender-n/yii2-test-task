<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FileRecord;

/**
 * Class FilesSearch
 * @package app\models
 */
class FilesSearch extends Model
{
    public $user_name;
    public $file_name;

    /**
     * @return array
     */
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['file_name'], 'string', 'max' => 255],
            [['user_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'search' => ['file_name', 'user_name'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FileRecord::find();

        $query->joinWith('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }



        // adjust the query by adding the filters
        $query->andFilterWhere(['user.username' => $this->user_name]);
        $query->andFilterWhere(['like', 'file_name', $this->file_name]);

        return $dataProvider;
    }
}

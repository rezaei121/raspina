<?php
namespace app\modules\file\models;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form about `dashboard\models\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','extension'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = File::find()->alias('file')->select(['file.*', 'user_id' => 'user.id', 'user.last_name','user.surname'])->leftJoin(['user' => User::tableName()], "uploaded_by = user.id");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'extension', $this->extension]);

        return $dataProvider;
    }
}

<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Emailentity;

/**
 * EmailentitySearch represents the model behind the search form about `frontend\models\Emailentity`.
 */
class EmailentitySearch extends Emailentity
{

    /**
     *
     * @var string Search in any of the fields
     */
    public $any;
    
    /**
     *
     * @var string Search in the target 
     */
    public $target;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 's';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'emaildomain_id', 'owner_id'], 'integer'],
            [['id', 'emaildomain_id', 'owner_id'], 'default', 'value' => NULL],
            [['id', 'emaildomain_id', 'owner_id'], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
            [['any', 'name', 'sortname', 'comment', 'target'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
            [
                'any' => 'Beliebiges Feld',
                'target' => 'Ziel',
            ]);
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
        $query = Emailentity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'emaildomain_id' => $this->emaildomain_id,
            'owner_id' => $this->owner_id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'sortname', $this->sortname])
            ->andFilterWhere(['ilike', 'comment', $this->comment]);

        if (!empty($this->target)) {
            $query->andWhere('exists (select 1 from tbl_emailmapping where tbl_emailentity.id = tbl_emailmapping.emailentity_id and emailarea_id <> 255 and target ilike :target )', [':target' => ('%' . strtr($this->target, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%')]);
        }

        if (!empty($this->any)) {
            $query->andWhere('(name ilike :any or sortname ilike :any or comment ilike :any)', [':any' => ('%' . strtr($this->any, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%')]);
        }

        return $dataProvider;
    }
    
    public function getFilterStatus()
    {
        if (isset($this->emaildomain)) {
            return $this->emaildomain->getCompleteDomainname();
        } 
        return 'Alle Adressen';
    }
}


<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmailentitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adressdruck';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emailentity-print">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n",
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_print', ['model' => $model, ]);
        },
    ]) ?>
    
    
</div>
<?php
?>

<?php

$css=<<<'css'
.emailentity-print {
    column-count: 2;
    column-gap: 40px;
    -webkit-column-count: 2;
    -webkit-column-gap: 40px;
    -moz-column-count: 2;
    -moz-column-gap: 40px;
}
css;
$this->registerCss($css);
?>

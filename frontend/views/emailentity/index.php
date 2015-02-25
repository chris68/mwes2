<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmailentitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adressen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emailentity-index">

    <div class="row">
    <div class="col-lg-6">
        
    <div class="form-group">
        <?= Html::a('Drucken', Url::toRoute(array_replace_recursive(['print'], Yii::$app->getRequest()->get())), ['target' => '_blank']) ?>
    </div>

    <?= $this->render('_searchsection', ['searchModel' => $searchModel]); ?>

    <div class="form-group">
        <div class="input-group">
            <?= Html::activeInput('search', $searchModel, 'any',['class' => 'form-control', 'form' => 'search_form', 'placeholder' => 'Schnellsuche']) ?>
            <span class="input-group-btn">
                <button type="submit" form="search_form" class="btn btn-search"><span class='glyphicon glyphicon-search'></span></button>
            </span>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Neuer Eintrag', ['create', 'emaildomain_id' => $searchModel->emaildomain_id], ['id' => 'create_item_trigger', 'class' => 'btn btn-sm btn-success']) ?>
    </div>
    <?php 
        Pjax::begin(['id' => 'item_new', 'enablePushState' => FALSE, 'linkSelector' => '#item_new a, #create_item_trigger', 'formSelector' => '#item_new form[data-pjax]']);
        Pjax::end();
    ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n{pager}\n{items}\n{pager}",
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_view', ['model' => $model, 'pjax'=> true]);
        },
    ]) ?>
    
    </div>
    </div>
    
</div>
<?php

$script=<<<'js'
// Catch the PJAX error event and fill/show the error box appropriately
$(document).on('pjax:error', function (event, xhr, textStatus, errorThrown, options) {
    $('#pjax-notification-error').text("Es ist ein HTTP-Fehler " + xhr.status + " aufgetreten." +
                    "\nBitte versuchen Sie die Operation noch einmal.");
    $('#pjax-notification-error').show()
    return;
});    
// Catch the PJAX send/complete event and show/hide the saving box appropriately
$(document).on('pjax:send', function() {
  $('#pjax-notification-sending').show()
})
$(document).on('pjax:complete', function() {
  $('#pjax-notification-sending').hide()
})
js;
$this->registerJs($script);
?>
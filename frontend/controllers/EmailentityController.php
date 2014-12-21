<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Emailentity;
use frontend\models\EmailentitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmailentityController implements the CRUD actions for Emailentity model.
 */
class EmailentityController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
					// todo method post currently does not play nice with pjax (see github.com/yiisoft/yii2/issues/2505)
                    // 'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Emailentity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailentitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query = $dataProvider->query->ownerScope();
		$dataProvider->sort->defaultOrder = ['emaildomain_id' => SORT_ASC, 'sortname' => SORT_ASC,];
		$dataProvider->pagination->pageSize = 20;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Emailentity model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		if (\Yii::$app->getRequest()->getIsPjax()) {
			return $this->renderPartial('view', [
				'model' => $this->findModel($id),
			]);
		}
		else {
			return $this->render('view', [
				'model' => $this->findModel($id),
			]);
		}
    }

    /**
     * Creates a new Emailentity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($emaildomain_id = NULL)
    {
        $model = new Emailentity();
		$model->emaildomain_id = $emaildomain_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (\Yii::$app->getRequest()->getIsPjax()) {
				return 
					$this->renderPartial('_view', [
						'model' => $model, 
						'pjax'=> true, 
					]);
			} else {
				return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
			if (\Yii::$app->getRequest()->getIsPjax()) {
				return $this->renderPartial('_form', [
					'model' => $model, 
					'pjax'=> true, 
				]);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
        }
    }

    /**
     * Updates an existing Emailentity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (\Yii::$app->getRequest()->getIsPjax()) {
				return 
					$this->renderPartial('_view', [
							'model' => $model,
							'pjax'=> true, 
					]);
			} else {
				return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
			if (\Yii::$app->getRequest()->getIsPjax()) {
				return $this->renderPartial('_form', [
					'model' => $model,
					'pjax'=> true, 
				]);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
        }
    }

    /**
     * Deletes an existing Emailentity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		
        $model = $this->findModel($id); $model->delete();

		if (\Yii::$app->getRequest()->getIsPjax()) {
			return \yii\bootstrap\Alert::widget([
				'body' => "'{$model->getCompleteEmailname()}' wurde gelöscht",
				'closeButton' => [],
				'options' => ['class' => 'alert-success'],
			]);
		} else {
			return $this->redirect(['index']);
		}
    }

    /**
     * Finds the Emailentity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Emailentity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Emailentity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

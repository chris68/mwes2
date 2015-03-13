<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Foreignemailaccount;
use frontend\models\ForeignemailaccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * ForeignemailaccountController implements the CRUD actions for Foreignemailaccount model.
 */
class ForeignemailaccountController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Foreignemailaccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Foreignemailaccount::find(),
        ]);
        $dataProvider->query->ownerScope();

        $dataProvider->sort->defaultOrder = ['confirmation_level' => SORT_DESC, 'emailaddress' => SORT_ASC, ];
        $dataProvider->pagination->pageSize = 20;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Foreignemailaccount model.
     * If creation is successful, the browser will be redirected to the 'request-confirmation' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Foreignemailaccount(['scenario' => Foreignemailaccount::SCENARIO_REGISTER]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['request-confirmation', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Foreignemailaccount model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Foreignemailaccount::SCENARIO_UPDATE);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Request the confirmation for an existing Foreignemailaccount model.
     * The browser will be redirected to the 'index' page afterwards
     * @param integer $id
     * @return mixed
     */
    public function actionRequestConfirmation($id)
    {
        $model = $this->findModel($id);

        if (!$model->isConfirmationTokenValid($model->confirmation_token)) {
            $model->generateConfirmationToken(); $model->save();
        }

        $sucess = Yii::$app->mailer->compose(['html' => 'mailConfirmationToken-html', 'text' => 'mailConfirmationToken-text'], ['model' => $model])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($model->emailaddress)
            ->setSubject('Emailbestätigung für ' . \Yii::$app->name)
            ->send();

        if ($sucess) {
            Yii::$app->getSession()->setFlash('success', 'Es wurde eine Bestätigungsmail an die Adresse geschickt. Bitte prüfen Sie Ihre Email für weitere Anweisungen.');
            return $this->redirect(['index']);
        } else {
            Yii::$app->getSession()->setFlash('error', 'Es gab beim Versenden der Bestätigungsmail leider einen Fehler. Versuchen Sie es später noch einmal.');
        }

        return $this->redirect(['index']);
    }

    public function actionConfirm($id, $token)
    {
        $model = $this->findModel($id);

        if ($model->confirm($token) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Die Adresse wurde erfolgreich betätigt. Sie können nun auch die Umleitung anpassen');
            return $this->redirect(['update', 'id'=> $id]);
        } else {
            Yii::$app->getSession()->setFlash('error', 'Die Bestätigung war leider nicht erfolgreich');
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing Foreignemailaccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Foreignemailaccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Foreignemailaccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Foreignemailaccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

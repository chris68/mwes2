<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

// @chris68
use common\models\Auth;
use common\models\User;
use yii\data\ActiveDataProvider;
use frontend\models\UserdataForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
// @chris68
                'only' => ['logout', 'signup', 'userdata', 'foreignlogin'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
// @chris68
                    [
                        'actions' => ['userdata','foreignlogin'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

// @chris68
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

// @chris68
        Yii::$app->session->setFlash('success','Sie haben sich erfolgreich abgemeldet.');
        
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (false && $model->sendEmail(Yii::$app->params['adminEmail'])) { // todo: integrate https://github.com/himiklab/yii2-recaptcha-widget
                Yii::$app->session->setFlash('success', \Yii::t('base','Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', \Yii::t('base','There was an error sending your message.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

     /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup($oauth='')
// @chris68
    {
        Yii::$app->getSession()->setFlash('error',
        'Eine Registierung ist wegen des nahenden Shutdowns leider nicht mehr möglich!');
        return $this->redirect(['/']);

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->getSession()->setFlash('success',
                      'Nach der erfolgreichen Registrierung können sich nun gerne optional mit einem Konto bei einem der unten aufgelisteten OAuth-Providern verbinden. Wenn Sie dort kein Konto haben oder die Verbindung nicht wollen, dann gehen Sie einfach auf Home oben im Menü');
                    return $this->redirect(['site/foreignlogin']);
                }
            }
        } else {
            if ($oauth == '1') {
              $model->username = Yii::$app->security->generateRandomString(10);
              $model->password = Yii::$app->security->generateRandomString(12);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', \Yii::t('base','Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', \Yii::t('base','Sorry, we are unable to reset password for the provided email address.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', \Yii::t('base','New password saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

// @chris68
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        Yii::info($attributes);

        /* @var $auth common\models\Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else {
                Yii::$app->getSession()->setFlash('error',
                    'Das angegebene Konto der externen Providers ist nicht mit einem Account auf unserer Plattform verbunden.<br/>'
                    .'Wenn Sie bereits bei uns registriert sind, dann melden Sie sich bitte an und verbinden Sie dann das Konto unter "Verwalten"->"Fremdlogins".<br/>'
                    .'Andernfalls müssen Sie sich zuerst unten registrieren (als Fallback zur Ihrer Sicherheit) und können erst dann das Konto verbinden. Bei der Registierung müssen Sie eigentlich nur Ihre Emailadresse angeben, der Rest ist bereits entsprechend vorgefüllt <br/>'
                    .''
                );
                return $this->redirect(['site/signup','oauth'=>'1']);
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                switch ($client->getId()) {
                    case 'google': $name = $attributes['displayName']; break;
                    case 'facebook': $name = $attributes['name']; break;
                }
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                    'source_name' => $name,
                ]);
                $auth->save();
            } else {
                if ($auth->user->id <> Yii::$app->user->id) {
                    Yii::$app->getSession()->setFlash('error', 'Das angegebene Konto des externen Providers ist bereits mit einem anderen Account auf unserer Plattform verbunden. Logischerweise kann man jedoch immer nur genau ein Konto von uns mit genau einem Konto des externen Providers verbinden.');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Das angegebene Konto des externen Providers ist bereits mit diesem Account auf unserer Plattform verbunden. Zweimal geht nicht!');
                }
            }
        }
    }

    public function actionTerms()
    {
        return $this->render('terms');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    public function actionImpressum()
    {
        return $this->render('impressum');
    }

    public function actionHelp()
    {
        return $this->render('help');
    }

    public function actionReleasehistory()
    {
        return $this->render('releasehistory');
    }

    public function actionUserdata()
    {
        $model = new UserdataForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                Yii::$app->getSession()->setFlash('success', 'Die Änderungen wurden übernommen');
                return $this->goHome();
            }
        }

        return $this->render('userdata', [
            'model' => $model,
        ]);
    }

    public function actionForeignlogin($delete='')
    {
        if ($delete=='ALL') {
            Auth::deleteAll("{{%auth}}.user_id = :owner", [':owner' => \Yii::$app->user->id]);
        }

        $query = Auth::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setPagination(false);
        $dataProvider->query->andWhere("{{%auth}}.user_id = :owner", [':owner' => \Yii::$app->user->id]);

        Yii::$app->getUser()->setReturnUrl(['/site/foreignlogin']);
        return $this->render('foreignlogin', [
            'dataProvider' => $dataProvider,
        ]);
    }
}

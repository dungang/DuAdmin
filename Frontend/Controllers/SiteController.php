<?php
namespace Frontend\Controllers;

use DuAdmin\Helpers\AppHelper;
use DuAdmin\Hooks\FindSlugHook;
use DuAdmin\Core\GuestController;
use Yii;
use Frontend\Forms\ContactForm;
use Frontend\Forms\PasswordResetRequestForm;
use yii\web\BadRequestHttpException;
use Frontend\Forms\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use Frontend\Forms\VerifyEmailForm;
use Frontend\Forms\ResendVerificationEmailForm;

/**
 * Site controller
 */
class SiteController extends GuestController
{

    public function init()
    {
        parent::init();

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => AppHelper::getSetting('site.keywords')
        ], 'keywords');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => AppHelper::getSetting('site.description')
        ], 'description');
    }

    /**
     *
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => '\yii\captcha\CaptchaAction',
                'offset' => '0',
                'maxLength' => 4,
                'minLength' => 4,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'upload' => [
                'class' => 'DuAdmin\Uploader\LocalUploadAction'
            ],
            'upload-token' => [
                'class' => 'DuAdmin\Uploader\TokenAction'
            ],
            'upload-delete' => [
                'class' => 'DuAdmin\Uploader\DeleteAction'
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * 检查是否有数据库级别的配置
     *
     *
     * @return string
     */
    public function actionIndex()
    {
        if ($url = AppHelper::getSetting("site.index-page")) {
            return $this->redirect($url);
        } else {
            return $this->render("index");
        }
    }

    /**
     * 显示页面
     *
     * @param string $slug
     * @throws \yii\web\NotFoundHttpException
     * @return mixed|NULL|string
     */
    public function actionPage($slug = 'index')
    {
        // try to display action from controller
 
        try {
            return $this->run('/'. $slug);
        } catch (\yii\base\InvalidRouteException $ex) {
            \Yii::debug($ex->getMessage());die;
        }

        // try to display action from application
        try {
            return \Yii::$app->runAction($slug . '/');
        } catch (\yii\base\InvalidRouteException $ex) {}

        // try to display static page from hook handler
        $hook = FindSlugHook::emit($this, [
            'slug' => $slug
        ]);
        if ($hook && $hook->payload) {
            return $hook->payload;
        }
        // if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

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
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }
            
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
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
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
     * @throws BadRequestHttpException::
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            
            return $this->goHome();
        }
        
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }
        
        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }
    
    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }
        
        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}

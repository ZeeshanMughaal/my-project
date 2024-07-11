<?php

class SiteController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	public function actionRegister()
	{
		$model = new RegistrationForm;
	
		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		// collect user input data
		if (isset($_POST['RegistrationForm'])) {
			$model->attributes = $_POST['RegistrationForm'];
			if ($model->validate()) {
				// Create a new user
				// Check if the email exists
				if(isset($model->email)){
					$email=$model->email;
						$exists = User::model()->exists('email=:email', array(':email' => $email));
						if($exists){
							Yii::app()->user->setFlash('email', 'Email Already Registered Try Other Email Address.');
							$this->redirect('register');
						}
					}
				$user = new User;
				$user->username = $model->username;
				$user->password = CPasswordHelper::hashPassword($model->password);
				$user->email = $model->email;
				$user->profile = $model->profile;
	
				// Generate a verification token
				$user->email_verification_token = md5(uniqid($user->email, true));
				$user->is_verified = 0; // Ensure the user is not verified initially
	
				if ($user->save()) {
					// Send verification email
					$verifyLink = Yii::app()->createAbsoluteUrl('site/verifyEmail', array('token' => $user->email_verification_token));
					$message = "Thank you for registering. Please verify your email by clicking the following link: <a href=\"$verifyLink\">Verify Email</a>";
					Yii::app()->mailer->sendEmail($model->email, "Verify EmailEmail", $message);
					
	
					Yii::app()->user->setFlash('registration', 'Thank you for registering. Please check your email for verification instructions.');
					$this->refresh();
				}
			}
		}
	
		// display the registration form
		$this->render('register', array('model' => $model));
	}
	public function actionVerifyEmail($token)
	{
		$user = User::model()->findByAttributes(array('email_verification_token' => $token));

		if ($user !== null) {
			$user->is_verified = 1; // Mark user as verified
			$user->email_verification_token = null; // Remove the verification token
			if ($user->save()) {
				Yii::app()->user->setFlash('verify', 'Your email has been successfully verified. You can now log in.');
				$this->redirect(Yii::app()->homeUrl); // Redirect to the homepage or login page
			}
		} else {
			Yii::app()->user->setFlash('error', 'Invalid verification token.');
			$this->redirect(Yii::app()->homeUrl); // Redirect to the homepage or an error page
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function actionVerifyAccount()
    {
        $this->render('verifyAccount');
    }
	public function actionCheckEmail()
	{
		if (Yii::app()->request->isPostRequest) {
			$email = Yii::app()->request->getPost('email');
			// print_r($email);die();
			$exists = User::model()->exists('email=:email', array(':email' => $email));
			echo CJSON::encode(array('exists' => $exists));
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

}

<?php

class SiteController extends Controller
{
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
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $brands = GetDir::getAllBrands();
		$this->render('index', array('brands' => $brands));
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
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
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
		$this->render('login',array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionGetDir()
    {
        if (!$_POST['sku']) {
            $manCode = GetDir::getManCode($_POST['brand']);
            $sku = $manCode . ' ' . preg_replace('/\//', '', $_POST['model']) . '-' . preg_replace('/\//', '', $_POST['color_code']);
            $images = GetDir::parseImages($sku, 'aff');
            $cases = GetDir::parseCases($sku, 'aff');
        } else {
            $sku = preg_replace('/\//', '', $_POST['sku']);
            $images = GetDir::parseImages($sku, 'aff');
            $cases = GetDir::parseCases($sku, 'aff');
        }
        if ($images) {
            foreach ($images as $image) {
                $dest_name = preg_split("/\//", $image);
                echo 'i:' . GetDir::resizeImage(substr($image, 0, -1),
                    '/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' .
                        $dest_name[3] . '/' . $dest_name[4] . '/' . substr($dest_name[5], 0, -1),
                    300, 150);
                //echo 'i:' . $image;
            }
        } else {
            echo GetDir::printException('images not found');
        }

        if ($cases) {
            foreach ($cases as $case) {
                $dest_name = preg_split("/\//", $case);
                echo 'c:' . GetDir::resizeImage(substr($case, 0, -1),
                    '/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' .
                        $dest_name[3] . '/' . $dest_name[4] . '/' . substr($dest_name[5], 0, -1),
                    300, 150);
                //echo 'c:' . $case;
            }
        } else {
            echo GetDir::printException('cases not found');
        }
    }

    public function actionGetShades()
    {
        if (!$_POST['sku']) {
            $manCode = GetDir::getManCode($_POST['brand']);
            $sku = $manCode . ' ' . preg_replace('/\//', '', $_POST['model']) . '-' . preg_replace('/\//', '', $_POST['color_code']);
            $images = GetDir::parseImages($sku, 'sh');
            $cases = GetDir::parseCases($sku, 'sh');
        } else {
            $sku = preg_replace('/\//', '', $_POST['sku']);
            $images = GetDir::parseImages($sku, 'sh');
            $cases = GetDir::parseCases($sku, 'sh');
        }
        if ($images) {
            foreach ($images as $image) {
                $dest_name = preg_split("/\//", $image);
                echo 'i:' . GetDir::resizeImage(substr($image, 0, -1),
                    '/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' .
                        $dest_name[4] . '/' . $dest_name[5] . '/' . substr($dest_name[6], 0, -1),
                    300, 150);
                //echo 'i:' . $image;
            }
        } else {
            echo GetDir::printException('images not found');
        }

        if ($cases) {
            foreach ($cases as $case) {
                $dest_name = preg_split("/\//", $case);
                echo 'c:' . GetDir::resizeImage(substr($case, 0, -1),
                    '/home/union-progress.com/public_html/feedhelper/picture_helper/temp/' .
                        $dest_name[4] . '/' . $dest_name[5] . '/' . substr($dest_name[6], 0, -1),
                    300, 150);
                //print_r($cases); die(1);
                //echo 'c:' . $case;
            }
        } else {
            echo GetDir::printException('cases not found');
        }
    }

    public function actionCheckCount()
    {
        //var_dump($_POST);die(1);
        echo Generators::checkCount();
    }
    public function actionAddToFeed()
    {
        //var_dump($_POST);die(1);
        echo Generators::addToFeed($_POST);
    }
    public function actionAzGen()
    {
        //var_dump($_POST);die(1);
        Generators::azGenerator($_POST, $_POST['mode']);
    }

    public function actionUkGen()
    {

    }

    public function actionFpGen()
    {

    }

    public function actionStdGen()
    {

    }

    public function actionJsonBrand()
    {
        echo GetDir::getPath($_POST['mcode']);
    }
}
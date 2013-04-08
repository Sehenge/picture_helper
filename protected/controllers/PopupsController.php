<?php

class PopupsController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
    public $layout = false;

	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

    public function actionTmpCont()
    {
        $this->render('tmpcont', array('data' => Generators::updateCont()));
    }
}
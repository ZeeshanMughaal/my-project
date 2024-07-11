
<?php

class VerifiedUserFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->loginRequired();
            return false;
        }
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->is_verified != 1) {
            Yii::app()->user->setFlash('error', 'Please check your email to verify your account.');
            
            Yii::app()->controller->redirect(array('site/verifyAccount'));
            return false;
        }


        return true;
    }
}

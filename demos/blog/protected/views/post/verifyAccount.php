<?php
/* @var $this SiteController */
/* @var $message string */
?>

<h1>Account Verification</h1>

<?php if (Yii::app()->user->hasFlash('verify')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('verify'); ?>
    </div>
<?php elseif (Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php else: ?>
    <p>
        Please Check your email for Verify Your Account.
    </p>
<?php endif; ?>

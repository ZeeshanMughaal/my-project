
<?php if(Yii::app()->user->hasFlash('email')): ?>
    <div class="flash-error">
    <?php echo Yii::app()->user->getFlash('email'); ?>
</div>
<?php endif;?>
<?php if (Yii::app()->user->hasFlash('registration')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('registration'); ?>
</div>

<?php else: ?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-form',
        'enableClientValidation' => true,
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email',array('id'=>'VerifyEmail')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Register'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php endif; ?>

<script>
    $(document).ready(function(){
        $("#VerifyEmail").on('blur',function(){
            var email = $(this).val();
            $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl("site/checkEmail"); ?>',
            data: { email: email },
            success: function(response) {
                if (JSON.parse(response).exists) {
                    $('#RegistrationForm_email_em_').text('This email is already registered.');
                    $("#RegistrationForm_email_em_").show();
                } else {
                    $('#RegistrationForm_email_em_').text('');
                }
            },
            error: function() {
                $('#email-exists-message').text('An error occurred while checking the email.');
            }
        });
        });
    });
</script>
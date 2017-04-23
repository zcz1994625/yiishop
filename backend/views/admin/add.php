<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'email');
//角色
echo $form->field($model,'roles')->checkboxList(\backend\models\Admin::getRoleOptions());
echo $form->field($model,'captcha')->widget(\yii\captcha\Captcha::className(),[
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>'
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
<h1>添加商品相册</h1>
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'img_file[]')->fileInput(['multiple'=>true]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
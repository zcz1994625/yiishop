<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\ArticleCategory::$statusOptions);
echo $form->field($model,'sort');
echo $form->field($model,'is_help',['inline'=>true])->radioList(\backend\models\ArticleCategory::$is_helpOptions);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>['bt btn-info']]);
\yii\bootstrap\ActiveForm::end();
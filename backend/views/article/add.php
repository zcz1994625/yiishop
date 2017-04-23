<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getCategoryOptions());
echo $form->field($model,'intro');
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Article::$statusOptions);
echo $form->field($model,'sort');
echo $form->field($model_detail,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'brn btn-info']);
\yii\bootstrap\ActiveForm::end();

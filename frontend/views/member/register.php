<?php
/* @var $this yii\web\View */

?>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';
            $button =  '<input type="button" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px">';

            echo $form->field($model,'username',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt']);
            //echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'password_hash',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->passwordInput(['class'=>'txt']);
            echo $form->field($model,'password',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->passwordInput(['class'=>'txt']);
            echo $form->field($model,'tel',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    //'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt']);
            echo $form->field($model,'email',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt']);
            echo $form->field($model,'code',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','style'=>'width:100px']);
            echo $form->field($model,'captcha',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                ]
            )->widget(\yii\captcha\Captcha::className(),[
                'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>'
            ]);
            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>



        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<?php
$url = \yii\helpers\Url::to(['member/code']);
$token = Yii::$app->request->csrfToken;

$js = <<<EOT

        $('#get_captcha').click(function(){
            var tel = $('#member-tel').val();
            $.post('{$url}',{tel:tel,"_csrf-frontend":'{$token}'},function(data){
                console.debug(data);
            });

               //启用输入框
			$('#captcha').prop('disabled',false);
			var time=30;
			var interval = setInterval(function(){
				time--;
				if(time<=0){
					clearInterval(interval);
					var html = '获取验证码';
					$('#get_captcha').prop('disabled',false);
				} else{
					var html = time + ' 秒后再次获取';
					$('#get_captcha').prop('disabled',true);
				}

				$('#get_captcha').val(html);
			},1000);
        })



EOT;
$this->registerJs($js);


?>



<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户登录</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <form action="" method="post">
                <?php
                $form = \yii\widgets\ActiveForm::begin();
                echo '<ul>';
                $button =  '<input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px">';

                echo $form->field($model,'username',
                    [
                        'options'=>['tag'=>'li'],//包裹整个输入框的标签
                        'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                    ]
                )->textInput(['class'=>'txt']);
                //echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
                echo $form->field($model,'password_hash',
                    [
                        'options'=>['tag'=>'li'],//包裹整个输入框的标签
                        'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                    ]
                )->passwordInput(['class'=>'txt']);
                echo $form->field($model,'captcha',
                    [
                        'options'=>['tag'=>'li'],//包裹整个输入框的标签
                        'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px'],//错误信息的标签
//                    'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
                    ]
                )->widget(\yii\captcha\Captcha::className(),[
                    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>'
                ]);
                echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
                echo '</ul>';
                \yii\widgets\ActiveForm::end();

                ?>
            </form>

            <div class="coagent mt15">
                <dl>
                    <dt>使用合作网站登录商城：</dt>
                    <dd class="qq"><a href=""><span></span>QQ</a></dd>
                    <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                    <dd class="yi"><a href=""><span></span>网易</a></dd>
                    <dd class="renren"><a href=""><span></span>人人</a></dd>
                    <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                    <dd class=""><a href=""><span></span>百度</a></dd>
                    <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                </dl>
            </div>
        </div>

        <div class="guide fl">
            <h3>还不是商城用户</h3>
            <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

            <a href="regist.html" class="reg_btn">免费注册 >></a>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="images/xin.png" alt="" /></a>
        <a href=""><img src="images/kexin.jpg" alt="" /></a>
        <a href=""><img src="images/police.jpg" alt="" /></a>
        <a href=""><img src="images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->

</body>
</html>
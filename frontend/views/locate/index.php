<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>
        <dl>
            <dt></dt>
            <dd>
                <a href="">修改</a>
                <a href="">删除</a>
                <a href="">设为默认地址</a>
            </dd>
        </dl>
    </div>

    <div class="address_bd mt10">
        <h4>新增收货地址</h4>
        <?php
           $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';

            echo $form->field($model,'name',[
                'options'=>['tag'=>'li'],//包裹整个输入框的标签
                'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px'],//错误信息的标签
            ])->textInput(['class'=>'txt']);


        ?>
        <script src="/js/Address.js"></script>
        省：<select id="cmbProvince" name="Address[provence]"></select>
        市：<select id="cmbCity"  name="Address[city]"></select>
        区：<select id="cmbArea"  name="Address[area]"></select>
        <br /><br />
        <script type="text/javascript">
            addressInit('cmbProvince', 'cmbCity', 'cmbArea', '请选择', '请选择', '请选择');
        </script>



        <?php
            echo $form->field($model,'locate',[
                'options'=>['tag'=>'li'],//包裹整个输入框的标签
                'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px'],//错误信息的标签
            ])->textInput(['class'=>'txt']);

        echo $form->field($model,'tel',[
            'options'=>['tag'=>'li'],//包裹整个输入框的标签
            'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px'],//错误信息的标签
        ])->textInput(['class'=>'txt']);
        echo $form->field($model,'status',[
            'options'=>['tag'=>'li'],//包裹整个输入框的标签
            'errorOptions'=>['tag'=>'p'],//错误信息的标签
        ])->checkbox(\frontend\models\Locate::$statusOptions);
        echo \yii\helpers\Html::submitButton('保存');
            echo '</ul>';
            \yii\widgets\ActiveForm::end();

        ?>
    </div>

</div>
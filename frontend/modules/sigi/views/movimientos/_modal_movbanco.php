<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
use common\helpers\h;
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">
<div class="box box-success">
    <div class="box box-body">
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/corte-cuenta','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fopera')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
 </div>
  
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'monto')->textInput() ?>
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'descripcion')->textInput()?>
 </div> 
 </div>
 
          
     

     
    <?php ActiveForm::end(); ?>

</div>
    </div></div>

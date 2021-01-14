<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\modules\sigi\models\SigiApoderadosSearch;
?>
<div class="edificios-indexhghg">

     <div class="box-body">
         
<?php
 $url= Url::to(['agrega-user','id'=>$model->id,'gridName'=>'grilla-apoderados','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar '), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Usuario'),'id'=>'btn_usuario', 'class' => 'botonAbre btn btn-success']); 
?> 
         
    <?php Pjax::begin(['id'=>'grilla-usuarios-edificio']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sigi\models\SigiUserEdificios::find()->where(['edificio_id'=>$model->id])
        ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                  [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{update}',
               'buttons' => [
                    'update' => function($url, $model) {  
                       $url= Url::to(['agrega-user','id'=>$model->id,'gridName'=>'grilla-usuarios-edificio','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>',$url,$options);
                     
                        
                        },
                      
                        
                    ]
                ],
           
            'usuario.username',
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    </div>
 </div>
       
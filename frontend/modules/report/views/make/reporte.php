<?php  use yii\grid\GridView;?>
<?=$contenidoSinGrilla?>
<div style="position:absolute; width:80%; left:<?php echo $modelo->x_grilla; ?>px; top:<?php echo $modelo->y_grilla; ?>px">
<?php if(true /*empty($modelo->vistaalterna)*/) {   ?>
   <?php echo $this->render($modelo->vistaalterna,
           [
       'dataProvider'=>$dataProvider
           ]);  ?> 
<?php }else {    ?> 
 <?php 
   
  
//use kartik\grid\GridView;
// echo $hojaestilo; yii::app()->end();
//var_dump($modelo->tienecabecera);
// ?>
  <?php 
if(count($columnas)>0)
echo GridView::widget([
        'id'=>'detallerepoGrid',
     'showFooter' => true,
    'summary' => '',
    //'showPageSummary' => true,
    //'striped' => true,
    'emptyCell'=>'',
    // 'showFooter' => true,
         // 'tableOptions'=>['class'=>'table no-margin'],
               'dataProvider' => $dataProvider,        
        'columns' =>$columnas ,
    // 'pager' => ['options'=>['visible'=>false]],
        ]
    );  ?>


</div>

<?php }?>


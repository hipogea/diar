<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_movimientos}}".
 *
 * @property int $id
 * @property int $idop
 * @property int $edificio_id
 * @property int $cuenta_id
 * @property string $fechaop
 * @property string $fechacre
 * @property string $tipomov
 * @property string $glosa
 * @property string $monto
 * @property string $igv
 * @property string $monto_usd
 * @property int $user_id
 * @property string $activo
 *
 * @property SigiCuentas $cuenta
 * @property SigiTipomov $tipomov0
 * @property SigiEdificios $edificio
 */
class SigiMovimientosPre extends \common\models\base\modelBase
{
   const SCE_CREACION_BASICA='basico';
    const SCE_STATUS='status';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_movimientos}}';
    }

     public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_CREACION_BASICA] = [
            'edificio_id', 'cuenta_id',
            'tipomov', 'glosa', 'monto',
             'activo','kardex_id'
            ];
         $scenarios[self::SCE_STATUS] = ['activo'];
       /* $scenarios[self::SCENARIO_ASISTIO] = ['asistio'];
        $scenarios[self::SCENARIO_PSICO] = ['codtra'];
        $scenarios[self::SCENARIO_ACTIVO] = ['activo'];
        $scenarios[self::SCENARIO_REPROGRAMA] = ['fechaprog', 'duracion', 'finicio', 'ftermino', 'codtra'];
        */return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idop', 'edificio_id', 'cuenta_id', 'user_id'], 'integer'],
            [['edificio_id', 'cuenta_id', /*'fechaop',*/  'tipomov', 'glosa', 'monto', /*'igv', 'monto_usd',*/ 'activo'], 'required'],
            [['monto', 'igv', 'monto_usd'], 'number'],
            [['fechaop'], 'string', 'max' => 10],
            [['kardex_id'], 'safe'],
            [['fechacre'], 'string', 'max' => 19],
            [['tipomov'], 'string', 'max' => 3],
            [['glosa'], 'string', 'max' => 40],
            [['activo'], 'string', 'max' => 1],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['tipomov'], 'exist', 'skipOnError' => true, 'targetClass' => SigiTipomov::className(), 'targetAttribute' => ['tipomov' => 'codigo']],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'idop' => Yii::t('sigi.labels', 'Idop'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'cuenta_id' => Yii::t('sigi.labels', 'Cuenta ID'),
            'fechaop' => Yii::t('sigi.labels', 'Fechaop'),
            'fechacre' => Yii::t('sigi.labels', 'Fechacre'),
            'tipomov' => Yii::t('sigi.labels', 'Tipomov'),
            'glosa' => Yii::t('sigi.labels', 'Glosa'),
            'monto' => Yii::t('sigi.labels', 'Monto'),
            'igv' => Yii::t('sigi.labels', 'Igv'),
            'monto_usd' => Yii::t('sigi.labels', 'Monto Usd'),
            'user_id' => Yii::t('sigi.labels', 'User ID'),
            'activo' => Yii::t('sigi.labels', 'Activo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuenta()
    {
        return $this->hasOne(SigiCuentas::className(), ['id' => 'cuenta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipomov()
    {
        return $this->hasOne(SigiTipomov::className(), ['codigo' => 'tipomov']);
    }
    
    public function getKardex()
    {
        return $this->hasOne(SigiKardexdepa::className(), ['id' => 'kardex_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiMovimientosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiMovimientosPreQuery(get_called_class());
    }
    
    public static function createBasic($attributes){
        $model = new SigiMovimientosPre();
        $model->setAttributes($attributes); 
        $oldScenario=$model->getScenario();
        $model->setScenario(self::SCE_CREACION_BASICA);
       if($model->save()){
           $model->setScenario($oldScenario);
            return $model;
       }else{
           $model->setScenario($oldScenario);
           return null; 
       }
       
      
        
    }
  /*
   * ESTA FUNCION SE ENCARGA DE SICRONIZAR
   */
  private function sincronizeStatus($insert=false){
    IF($this->kardex_id > 0) {
         $kardex=$this->kardex;
        IF($insert){
            $kardex->cancelado=$kardex::STATUS_CANCELADO_PREV;
        }else{
          if($this->hasChanged('activo')){
           $kardex->cancelado=($this->activo)?
                   true:
                   false; 
          }
           
        }
        $kardex->save();
     }      
  }
    
    
  public function beforeSave($insert) {
      $this->sincronizeStatus($insert);
      return parent::beforeSave($insert);
  }  
    
}

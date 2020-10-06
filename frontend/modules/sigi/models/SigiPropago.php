<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_propago}}".
 *
 * @property int $id
 * @property int $porpagar_id
 * @property int $edificio_id
 * @property string $fechaprog
 * @property string $nivel
 * @property string $cuenta
 * @property string $cci
 * @property string $codestado
 *
 * @property SigiEdificios $edificio
 * @property SigiPorpagar $porpagar
 */
class SigiPropago extends \common\models\base\modelBase
{
   const ESTADO_CREADO='10';
    const ESTADO_ANULADO='99';
    const ESTADO_PAGADO='20';
    const SCE_AUTO='auto';
    const SCE_ESTADO='estado';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_propago}}';
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_AUTO] = [
            'porpagar_id',
            'edificio_id',
            'fechaprog',
            'cuenta_id'
            ];
         $scenarios[self::SCE_ESTADO] = [
            'codestado',
            ];
       return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['porpagar_id', 'edificio_id', 'fechaprog', 'nivel', 'cuenta', 'cci', 'codestado'], 'required'],
            [['porpagar_id', 'edificio_id'], 'integer'],
            [['cuenta_id'], 'safe'],
            [['nivel'], 'string', 'max' => 1],
            [['cuenta'], 'string', 'max' => 30],
            [['cci'], 'string', 'max' => 12],
            [['codestado'], 'string', 'max' => 2],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['porpagar_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiPorpagar::className(), 'targetAttribute' => ['porpagar_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'porpagar_id' => Yii::t('sigi.labels', 'Porpagar ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'fechaprog' => Yii::t('sigi.labels', 'Fechaprog'),
            'nivel' => Yii::t('sigi.labels', 'Nivel'),
            'cuenta' => Yii::t('sigi.labels', 'Cuenta'),
            'cci' => Yii::t('sigi.labels', 'Cci'),
            'codestado' => Yii::t('sigi.labels', 'Codestado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(SigiEdificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPorpagar()
    {
        return $this->hasOne(SigiPorpagar::className(), ['id' => 'porpagar_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiPropagoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiPropagoQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
      if($insert){
          $this->codestado=self::ESTADO_CREADO;
      }
        return parent::beforeSave($insert);
    }
    
    
    public static function estadosValidos(){
        return [self::ESTADO_CREADO,self::ESTADO_PAGADO];
    }
}

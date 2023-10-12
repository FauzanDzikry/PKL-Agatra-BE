<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use common\models\Image;
use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "portfolio".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $image_id
 * @property string|null $path
 * @property string|null $image_url
 * @property int|null $client_id
 * @property int|null $is_deleted 
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by 
 * @property int|null $deleted_by
 * 
 * @property User $createdBy
 * @property User $updatedBy
 */
class Portfolio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portfolio';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class'=> TimestampBehavior::class,
                'value'=> new Expression('NOW()'),
            ],
             BlameableBehavior::class,           
        ]; 
    }
   /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description',], 'required'],
            [['client_id'], 'required','message' => 'choose a client'],
            [['description'], 'string'],
            [['path'], 'string'],
            [['image_id', 'client_id', 'is_deleted', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at','image_id', 'client_id', 'deleted_at'], 'safe'],
            [['title', 'path', 'image_url'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image_id' => 'Image',
            'path' => 'Path',
            'image_url' => 'Image Url',
            'client_id' => 'Client',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];     
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
    public function getImageTable()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }
    /**
     * Gets query for [[DeletedBy]].
     *
     * return \yii\db\BaseActiveRecord
     */
/*     public function getDeletedBy()
    {
        return $this->afterDelete(User::class, ['id' => 'deleted_by']);
    } */
}









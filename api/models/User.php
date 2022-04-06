<?php

namespace app\models;

use Yii;
use yii\db\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int         $id
 * @property string      $email
 * @property string|null $password
 * @property int         $blocked
 * @property int         $confirmed
 * @property string|null $auth_key
 * @property int         $role
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $last_login_at
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email', 'name'], 'trim'],
            [['blocked', 'confirmed', 'role', 'created_at', 'updated_at', 'last_login_at'], 'integer'],
            [['email', 'slug'], 'string', 'max' => 255],
            [['password', 'address'], 'string', 'max' => 60],
            [['auth_key', 'name', 'city'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
            [['state'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 5],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'auth_key' => [
                'class'      => 'yii\behaviors\AttributeBehavior',
                'attributes' => [static::EVENT_BEFORE_INSERT => 'auth_key'],
                'value'      => Yii::$app->security->generateRandomString(),
            ],
            'slug'     => [
                'class'        => SluggableBehavior::class,
                'attribute'    => 'name',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'email'         => 'Email',
            'password'      => 'Password',
            'blocked'       => 'Blocked',
            'confirmed'     => 'Confirmed',
            'auth_key'      => 'Auth Key',
            'role'          => 'Role',
            'name'          => 'Name',
            'slug'          => 'Slug',
            'phone'         => 'Phone',
            'address'       => 'Address',
            'city'          => 'City',
            'state'         => 'State',
            'zip'           => 'Zip',
            'created_at'    => 'Created At',
            'updated_at'    => 'Updated At',
            'last_login_at' => 'Last Login At',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Generates password hash token for new User
     *
     * @param bool $insert
     *
     * @return bool
     * @throws Exception
     */
    public function beforeSave($insert) : bool
    {
        if($insert) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->role = $this->role ?? Role::USER;
        }

        return parent::beforeSave($insert);
    }

    /**
     * For User Logout
     * @return int
     */
    public function resetAuthKey() : int
    {
        return $this->updateAttributes(['auth_key' => null]);
    }

    public function generateAuthKey()
    {
        return $this->updateAttributes(['auth_key' => Yii::$app->security->generateRandomString()]);
    }
}

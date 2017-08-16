<?php
namespace dashboard\modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class User extends \common\models\User implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $password;
    public $old_password;
    public $new_password;
    public $password_repeat;
    public $avatar;
    public $role;
    public function rules()
    {
        $parentRules = [];
        $parentRules[] = ['status', 'default', 'value' => self::STATUS_ACTIVE];
        $parentRules[] = ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]];
        $parentRules[] = [['old_password','new_password','password_repeat'], 'required','on' => 'changepassword'];
        $parentRules[] = [['last_name','surname'], 'string', 'max' => 255, 'min' => 3];
        $parentRules[] = [['email'], 'email'];
        $parentRules[] = [['username','email'], 'string', 'max' => 255];
        $parentRules[] = [['password', 'old_password','new_password','password_repeat'], 'string', 'max' => 255];

        $parentRules[] = [['username'], 'string', 'min' => 5];
        $parentRules[] = [['role'], 'checkValidRole', 'on' => ['create', 'update']];
        $parentRules[] = [['password', 'old_password','new_password','password_repeat'], 'string', 'min' => 7];
        $parentRules[] = [['username', 'last_name', 'surname', 'password', 'password_repeat', 'email'], 'required', 'on' => 'create'];
        $parentRules[] = [['username', 'last_name', 'surname', 'password', 'password_repeat', 'email'], 'trim', 'on' => 'create'];
        $parentRules[] = ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => ['create', 'update-password']];

        $parentRules[] = [['username', 'last_name', 'surname', 'email'], 'required', 'on' => 'update'];
        $parentRules[] = [['username', 'last_name', 'surname', 'email'], 'trim', 'on' => 'update'];

        $parentRules[] = [['password', 'password_repeat'], 'required', 'on' => 'update-password'];
        $parentRules[] = [['password', 'password_repeat'], 'trim', 'on' => 'update-password'];

        $parentRules[] = [['status'], 'integer'];
        $parentRules[] = [['username', 'last_name', 'surname', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255];
        $parentRules[] = [['auth_key'], 'string', 'max' => 32];
        $parentRules[] = [['username'], 'unique'];
        $parentRules[] = [['email'], 'unique'];
        $parentRules[] = [['password_reset_token'], 'unique'];

        return $parentRules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $parentAttributeLabels = parent::attributeLabels();
        $parentAttributeLabels['password'] = Yii::t('app', 'Password');
        $parentAttributeLabels['password_repeat'] = Yii::t('app', 'Repeat Password');
        return $parentAttributeLabels;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getStatus()
    {
        return [
            '10' => Yii::t('app','Active'),
            '0' => Yii::t('app','Deactive'),
        ];
    }

    public function getRols()
    {
        return [
            'author' => Yii::t('app','Author'),
            'moderator' => Yii::t('app','Admin'),
        ];
    }

    public function checkValidRole()
    {
        $roles = array_keys($this->getRols());
        if(!in_array($this->role, $roles))
        {
            $this->addError('role', Yii::t('app', 'Role not valid.'));
        }
    }
}

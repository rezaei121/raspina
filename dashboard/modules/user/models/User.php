<?php
namespace dashboard\modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class User extends \common\models\User implements IdentityInterface
{
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
        $parentRules[] = [['about_text'], 'string'];
        $parentRules[] = [['password', 'old_password','new_password','password_repeat'], 'string', 'max' => 255];

        $parentRules[] = [['username'], 'string', 'min' => 5];
        $parentRules[] = [['role'], 'checkValidRole', 'on' => ['create', 'update']];
        $parentRules[] = [['password', 'old_password','new_password','password_repeat'], 'string', 'min' => 7];
        $parentRules[] = [['username', 'last_name', 'surname', 'password', 'password_repeat', 'email'], 'required', 'on' => 'create'];
        $parentRules[] = [['username', 'last_name', 'surname', 'password', 'password_repeat', 'email'], 'trim', 'on' => 'create'];
        $parentRules[] = ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => ['create']];
        $parentRules[] = ['password_repeat', 'compare', 'compareAttribute' => 'new_password', 'on' => ['create', 'update-password']];

        $parentRules[] = [['username', 'last_name', 'surname', 'email'], 'required', 'on' => 'update'];
        $parentRules[] = [['username', 'last_name', 'surname', 'email'], 'trim', 'on' => 'update'];

        $parentRules[] = [['old_password', 'new_password', 'password_repeat'], 'required', 'on' => 'update-password'];
        $parentRules[] = [['old_password', 'new_password', 'password_repeat'], 'trim', 'on' => 'update-password'];

        $parentRules[] = [['status'], 'integer'];
        $parentRules[] = [['username', 'last_name', 'surname', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255];
        $parentRules[] = [['auth_key'], 'string', 'max' => 32];
        $parentRules[] = [['username'], 'unique'];
        $parentRules[] = [['email'], 'unique'];
        $parentRules[] = [['password_reset_token'], 'unique'];
        $parentRules[] = [['old_password'], 'validateOldPassword'];

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
        $parentAttributeLabels['old_password'] = Yii::t('app', 'Old Password');
        $parentAttributeLabels['new_password'] = Yii::t('app', 'New Password');
        return $parentAttributeLabels;
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

    public function validateOldPassword($attribute)
    {
        $user = User::findByUsername(Yii::$app->user->identity->username);
        if(!$user->validatePassword($this->old_password))
        {
            $this->addError($attribute, Yii::t('app','Incorrect old password.'));
        }
    }

}

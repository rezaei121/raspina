<?php
namespace app\modules\user\models;

use Yii;
use yii\web\IdentityInterface;

class User extends \app\modules\user\models\base\BaseUser implements IdentityInterface
{
    public $password;
    public $old_password;
    public $new_password;
    public $password_repeat;
    public $avatar;
    public $role;
    public function rules()
    {
        $rules = [];
        $rules[] = ['status', 'default', 'value' => self::STATUS_ACTIVE];
        $rules[] = ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]];
        $rules[] = [['old_password','new_password','password_repeat'], 'required','on' => 'changepassword'];
        $rules[] = [['last_name','surname'], 'string', 'max' => 255, 'min' => 3];
        $rules[] = [['email'], 'email'];
        $rules[] = [['username','email'], 'string', 'max' => 128];
        $rules[] = [['about_text'], 'string'];
        $rules[] = [['password', 'old_password','new_password','password_repeat'], 'string', 'max' => 255];

        $rules[] = [['username'], 'string', 'min' => 5];
        $rules[] = [['role'], 'checkValidRole', 'on' => ['create', 'update']];
        $rules[] = [['password', 'old_password','new_password','password_repeat'], 'string', 'min' => 7];
        $rules[] = [['username', 'last_name', 'surname', 'password', 'password_repeat', 'email'], 'required', 'on' => 'create'];
        $rules[] = [['username', 'last_name', 'surname', 'password', 'password_repeat', 'email'], 'trim', 'on' => 'create'];
        $rules[] = ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => ['create']];
        $rules[] = ['password_repeat', 'compare', 'compareAttribute' => 'new_password', 'on' => ['update-password']];

        $rules[] = [['username', 'last_name', 'surname', 'email'], 'required', 'on' => 'update'];
        $rules[] = [['username', 'last_name', 'surname', 'email'], 'trim', 'on' => 'update'];

        $rules[] = [['old_password', 'new_password', 'password_repeat'], 'required', 'on' => 'update-password'];
        $rules[] = [['old_password', 'new_password', 'password_repeat'], 'trim', 'on' => 'update-password'];

        $rules[] = [['status'], 'integer'];
        $rules[] = [['username', 'last_name', 'surname', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255];
        $rules[] = [['auth_key'], 'string', 'max' => 32];
        $rules[] = [['username'], 'unique', 'on' => 'create'];
        $rules[] = [['email'], 'unique'];
        $rules[] = [['password_reset_token'], 'unique'];
        $rules[] = [['old_password'], 'validateOldPassword'];
        $rules[] = [['avatar'], 'required', 'on' => 'avatar'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['password'] = Yii::t('app', 'Password');
        $attributeLabels['password_repeat'] = Yii::t('app', 'Repeat Password');
        $attributeLabels['old_password'] = Yii::t('app', 'Old Password');
        $attributeLabels['new_password'] = Yii::t('app', 'New Password');
        $attributeLabels['avatar'] = Yii::t('app', 'Avatar');
        return $attributeLabels;
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

    public function avatar()
    {
        return self::getAvatar($this->id);
    }

    public function name()
    {
        return "{$this->last_name} {$this->surname}";
    }

    public function about()
    {
        return $this->about_text;
    }

    public static function getAvatar($userId)
    {
        $baseUrl = Yii::$app->params['url'] . 'files/avatar/';
        $avatarPath = Yii::getAlias('@user_avatar') . DIRECTORY_SEPARATOR . Yii::$app->hashids->encode($userId) . '.jpg';

        if(file_exists($avatarPath))
        {
            return $baseUrl . Yii::$app->hashids->encode(Yii::$app->user->id) . '.jpg?' . microtime();
        }
        else
        {
            return $baseUrl . 'default.png';
        }
    }
}

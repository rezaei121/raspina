<?php

namespace app\modules\file\models;

use app\modules\user\models\User;
use Yii;
use yii\db\Query;


class File extends \app\modules\file\models\base\BaseFile
{
    public $myfile;

    /**
     * @inheritdoc
     */
    public $user_id;
    public $last_name;
    public $surname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['myfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'gif, png, jpg, pdf, doc, docx, xls, xlsx, ppt, pptx, txt, zip, rar, flv, avi, wmv, mp4, mpg, 3gp, mkv, mp3, ogg', 'maxFiles' => 4, 'maxSize' => ((int)ini_get('upload_max_filesize')) * pow(1024,2)];
        return $rules;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUploadedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'uploaded_by']);
    }

    public function upload()
    {
        $files_detail = [];
        if (!empty($this->myfile)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            foreach ($this->myfile as $file)
            {
                $real_name = md5(Yii::$app->user->id . time() . $file->baseName . microtime());
                $file_path = Yii::getAlias('@file_upload') . '/' . $real_name . '.' . $file->extension;
                if($file->saveAs($file_path))
                {
                    $files_detail[] = [
                        'name' => $file->baseName,
                        'extension' => $file->extension,
                        'size' => $file->size,
                        'uploaded_by' => Yii::$app->user->id,
                        'real_name' => $real_name,
                        'content_type' => finfo_file($finfo, $file_path)
                    ];
                }

            }

            if(!empty($files_detail))
            {
                $connection = new Query();
                $connection->createCommand()->batchInsert($this->tableName(),['name','extension','size','uploaded_by','real_name','content_type'],$files_detail)->execute();
            }
            return true;
        } else {
            return false;
        }
    }


    public function filesInfo()
    {
        $query = new \yii\db\Query();
        return $query->select('COUNT(id) AS `count`,format(SUM(size) / (1024 * 1024),1) AS `sum`')->from($this->tableName())->one();
    }
}

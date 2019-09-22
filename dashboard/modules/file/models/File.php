<?php

namespace dashboard\modules\file\models;

use dashboard\modules\user\models\User;
use Yii;


class File extends \common\models\File
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
        return [
            [['myfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'gif, png, jpg, pdf, doc, docx, xls, xlsx, ppt, pptx, txt, zip, rar, flv, avi, wmv, mp4, mpg, 3gp, mkv, mp3, ogg', 'maxFiles' => 4, 'maxSize' => ((int)ini_get('upload_max_filesize')) * pow(1024,2)],
        ];
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
        if ($this->validate()) {
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
            return $files_detail;
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

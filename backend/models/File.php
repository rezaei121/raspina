<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $name
 * @property string $size
 * @property string $upload_date
 */
class File extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public $myfile;
    public function rules()
    {
        return [
//            [['size', 'upload_date'], 'integer'],
//            [['name'], 'string', 'max' => 255],
            [['myfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'gif, png, jpg, pdf, doc, docx, xls, xlsx, ppt, pptx, txt, zip, rar, flv, avi, wmv, mp4, mpg, 3gp, mkv, mp3, ogg', 'maxFiles' => 4, 'maxSize' => ((int)ini_get('upload_max_filesize')) * pow(1024,2)],
        ];
    }

    public function upload()
    {
        $files_detail = [];
        if ($this->validate() && RASPINA_ENV != 'demo') {
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
                        'upload_date' => time("now"),
                        'user_id' => Yii::$app->user->id,
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
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'size' => Yii::t('app', 'Size'),
            'extension' => Yii::t('app', 'Extension'),
            'upload_date' => Yii::t('app', 'Upload Date'),
            'download_count' => Yii::t('app', 'Download Count')
        ];
    }
}

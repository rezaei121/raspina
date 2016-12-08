<?php

namespace frontend\controllers;

use Yii;
use backend\models\File;
use yii\db\Query;
use yii\web\Controller;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    public static $download = 0;
    public function actionDownload($id)
    {
        $sult = Yii::$app->setting->getSult();
        $hashids = new \common\components\hashids\Hashids($sult,5);
        $id = $hashids->decode($id);
        if(!empty($id[0]))
        {
            $model = File::findOne($id[0]);

            if(!empty($model))
            {
                if(!\backend\models\Visitors::isBot())
                {
                    $connection = new Query;
                    $connection->createCommand()->update(File::tableName(),['download_count' => $model->download_count + 1],'id = ' . $id[0])->execute();
                }

                $file_path = Yii::getAlias('@common') . '/files/upload/' . $model->real_name . '.' . $model->extension;
                header('Content-Description: File Transfer');
                header("Content-Type: " . $model->content_type);
                header('Content-Disposition: inline; filename="'.$model->name . '.' . $model->extension);
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . $model->size);
                if($this::$download == 0)
                {
                     readfile($file_path);
                    $this::$download == 1;
                }
            }
        }
    }
}

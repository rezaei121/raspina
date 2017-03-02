<?php
namespace developit\jcrop\actions;
use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use developit\jcrop\Jcrop;
class Upload extends Action
{
    public $path;
    public $url;
    public $uploadParam = 'file';
    public $name;
    public $maxSize = 2097152;
    public $extensions = 'jpeg, jpg, png, gif';
    public $width = 200;
    public $height = 200;
    /**
     * @inheritdoc
     */
    public function init()
    {
        Jcrop::registerTranslations();
        if ($this->url === null) {
            throw new InvalidConfigException(Yii::t('jcrop', 'Missing Attribute', ['attribute' => 'url']));
        } else {
            $this->url = rtrim($this->url, '/') . '/';
        }
        if ($this->path === null) {
            throw new InvalidConfigException(Yii::t('jcrop', 'Missing Attribute', ['attribute' => 'path']));
        } else {
            $this->path = rtrim(Yii::getAlias($this->path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName($this->uploadParam);
            $model = new DynamicModel(compact($this->uploadParam));
            $model->addRule($this->uploadParam, 'image', [
                'maxSize' => $this->maxSize,
                'tooBig' => Yii::t('jcrop', 'File Size Error', ['size' => $this->maxSize / (1024 * 1024)]),
                'extensions' => explode(', ', $this->extensions),
                'wrongExtension' => Yii::t('jcrop', 'File Extension Error', ['formats' => $this->extensions])
            ])->validate();
            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError($this->uploadParam)
                ];
            } else {
                if($this->name === null)
                {
                    $this->name = uniqid();
                }
                $model->{$this->uploadParam}->name = $this->name . '.jpg';
                $request = Yii::$app->request;
                $width = $request->post('width', $this->width);
                $height = $request->post('height', $this->height);
                $image = Image::crop(
                    $file->tempName . $request->post('filename'),
                    intval($request->post('w')),
                    intval($request->post('h')),
                    [$request->post('x'), $request->post('y')]
                )->resize(
                    new Box($width, $height)
                );
                if ($image->save($this->path . $model->{$this->uploadParam}->name)) {
                    $result = [
                        'filelink' => $this->url . $model->{$this->uploadParam}->name . '?' . microtime()
                    ];
                } else {
                    $result = [
                        'error' => Yii::t('jcrop', 'Can Not Upload File')]
                    ;
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        } else {
            throw new BadRequestHttpException(Yii::t('jcrop', 'Only POST Request'));
        }
    }
}
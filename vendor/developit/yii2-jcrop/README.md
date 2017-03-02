 image cropping
===============
 yii2 image cropping extension 

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist developit/yii2-jcrop "*"
```

or add

```
"developit/yii2-jcrop": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
use developit\jcrop\Jcrop;
<?= $form->field($model, 'avatar')->widget(Jcrop::className(), [
    'uploadUrl' => Url::toRoute('/user/avatar'),
])->label(false) ?>
```

Widget has following properties:

| Name     | Description    | Default |  Required   |
| --------|---------|-------|------|
| uploadParameter  | Upload parameter name | file    |No |
| width  | The final width of the image after cropping | 200    |No |
| height  | The final height of the image after cropping | 200    |No |
| uploadUrl  | URL for uploading and cropping image |     |Yes |
| maxSize  | The maximum file size (b).  | 2097152    |No |
| cropAreaWidth  | Width box for preview | 300    |No |
| cropAreaHeight  | Height box for preview | 300    |No |
| extensions  | Allowed file extensions (string). | jpeg, jpg, png, gif    |No |

In UserController:

```php
    public function actions()
    {
        return [
            'avatar' => [
                'class' => 'developit\jcrop\actions\Upload',
                'url' => '/common/files/',
                'path' => Yii::getAlias('@files'),
                'name' => Yii::$app->user->id
            ]
        ];
    }
```
	
Action has following parameters:

| Name     | Description    | Default |  Required   |
| --------|---------|-------|------|
| path  | Path for saving image after cripping |     |Yes |
| url  | URL to which the downloaded images will be available. |  |Yes |
| name  | uploded file name. |  |No |
| uploadParameter  | Upload parameter name. It must match the value of a similar parameter of the widget. | file    |No |
| maxSize  | The maximum file size (b). It must match the value of a similar parameter of the widget. | 2097152    |No |
| extensions  | Allowed file extensions (string). It must match the value of a similar parameter of the widget. | jpeg, jpg, png, gif    |No |
| width  | The final width of the image after cropping. It must match the value of a similar parameter of the widget. | 200    |No |
| height  | The final height of the image after cropping. It must match the value of a similar parameter of the widget. | 200    |No |

Operates as follows:
--------------------
![screenshot](http://www.developit.ir/tmp/jcrop1.jpg)
![screenshot](http://www.developit.ir/tmp/jcrop2.jpg)

License
-------
yii2-jcrop is an open source project modified by Ehsan Rezaei(http://www.developit.ir) that is licensed under GPL-3.0.
used and modified from https://github.com/budyaga/yii2-cropper

<?php

namespace developit\captcha;
use Yii;
use yii\helpers\Url;
use yii\web\Response;

class CaptchaAction extends \yii\captcha\CaptchaAction
{
    public $fontFile = '@developit/captcha/font/LithosPro-Regular.otf';
    public $foreColor = 0x999999;
    public $type = 'default'; // numbers & letters

    public function run()
    {
        if (Yii::$app->request->getQueryParam(self::REFRESH_GET_VAR) !== null) {
            // AJAX request for regenerating code
            $code = $this->getVerifyCode(true);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'hash1' => $this->generateValidationHash($code),
                'hash2' => $this->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url' => Url::to([$this->id, 'v' => uniqid()]),
            ];
        } else {
            $this->setHttpHeaders();
            Yii::$app->response->format = Response::FORMAT_RAW;
            return $this->renderImage($this->getVerifyCode());
        }
//        $view->registerJs('yii.captcha.validation.js');
    }

    protected function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        if ($this->minLength < 4) {
            $this->minLength = 4;
        }
        if ($this->maxLength > 9) {
            $this->maxLength = 9;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        $str = '0123456789bcdfghjklmnpqrstvwxyz';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            switch ($this->type)
            {
                case 'numbers':
                    $code .= $str[mt_rand(0, 9)];
                    break;
                case 'letters':
                    $code .= $str[mt_rand(10, 30)];
                    break;
                default:
                    $code .= $str[mt_rand(0, 30)];
            }
        }

        return $code;
    }

    public function validate($input, $caseSensitive)
    {
        $input = $this->_changeInvalidNumbers($input);
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;
        $session = Yii::$app->getSession();
        $session->open();
        $name = $this->getSessionKey() . 'count';
        $session[$name] = $session[$name] + 1;
        if ($valid || $session[$name] > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
        }

        return $valid;
    }

    private function _changeInvalidNumbers($input)
    {
        $enNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        $faNumbers = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $arNumbers = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $input = str_replace($faNumbers,$enNumbers,$input);
        $input = str_replace($arNumbers,$enNumbers,$input);

        return $input;
    }
}

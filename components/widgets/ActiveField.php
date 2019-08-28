<?php
namespace app\components\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField
{
    public $template = "{input}\n{hint}\n{error}";

    /**
     * Adds aria attributes to the input options
     * @param $options array input options
     * @since 2.0.11
     */
    protected function addAriaAttributes(&$options)
    {
        $options = array_merge($options, ['placeholder' => $this->model->getAttributeLabel($this->attribute)]);

        if ($this->addAriaAttributes) {
            if (!isset($options['aria-required']) && $this->model->isAttributeRequired($this->attribute)) {
                $options['aria-required'] =  'true';
            }
            if (!isset($options['aria-invalid'])) {
                if ($this->model->hasErrors($this->attribute)) {
                    $options['aria-invalid'] = 'true';
                }
            }
        }
    }
}
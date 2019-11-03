<?php
namespace app\components\helpers;

use Yii;

class Html extends \yii\helpers\Html
{
    protected static $template;
    protected static $buttons;

    /**
     * @return string
     */
    public function beginRow()
    {
        return '<div class="row">';
    }

    /**
     * @return string
     */
    public function endRow()
    {
        return '</div>';
    }

    /**
     * @param $title
     * @param string $size
     * @param array $panelClass
     * @param array $headingClass
     * @param array $bodyClass
     * @return string
     */
    public static function beginPanel($title, $size = 'col-md-12', $panelClass = ['panel', 'panel-default'], $headingClass = ['panel-heading'], $bodyClass = ['panel-body'])
    {
        $panelClass = (!$panelClass)? ['panel', 'panel-default'] : $panelClass;
        $headingClass = (empty($headingClass))? ['panel-heading'] : $headingClass;
        $bodyClass = (!$bodyClass)? ['panel-body'] : $bodyClass;
        $title = ($title !== null)? '<div class="' . implode(' ', $headingClass) . '">' . $title . '</div>' : null;

        return '<div class="' . $size . '">
                    <div class="' . implode(' ', $panelClass) . '">
                        ' . $title . '
                        <div class="' . implode(' ', $bodyClass) . '">';
    }

    /**
     * @return string
     */
    public static function endPanel()
    {
        return '</div></div></div>';
    }

    /**
     * @param array $template
     * @return mixed
     */
    public static function actionButtons($model ,$template = ['update', 'delete'])
    {
        static::$template = $template;
        static::initDefaultButtons($model);

        return '<div class="pull-left action-buttons-panel">' . static::$buttons . '</div><div class="clear"></div>';
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected static function initDefaultButtons($model)
    {
        static::initDefaultButton('view', 'eye', ['class' => 'btn btn-info']);

        $getClass = explode('\\', get_class($model));
        $className = end($getClass);

        if(Yii::$app->user->can("update{$className}", ['model' => $model]) || Yii::$app->user->can("updateOwn{$className}", ['model' => $model]))
        {
            static::initDefaultButton('update', 'pencil', ['class' => 'btn btn-primary']);
        }

        if(Yii::$app->user->can("approve{$className}", ['model' => $model]) || Yii::$app->user->can("approveOwn{$className}", ['model' => $model]))
        {
            static::initDefaultButton('approve', 'check', ['class' => 'btn btn-success']);
        }

        if(Yii::$app->user->can("delete{$className}", ['model' => $model]) || Yii::$app->user->can("deleteOwn{$className}", ['model' => $model]))
        {
            static::initDefaultButton('delete', 'trash', [
                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'class' => 'btn btn-danger'
            ]);
        }
    }

    /**
     * Initializes the default button rendering callback for single button
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected static function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (in_array($name, static::$template) !== false) {
            switch ($name) {
                case 'view':
                    $title = Yii::t('yii', 'View');
                    break;
                case 'update':
                    $title = Yii::t('yii', 'Update');
                    break;
                case 'approve':
                    $title = Yii::t('app', 'Approve');
                    break;
                case 'delete':
                    $title = Yii::t('yii', 'Delete');
                    break;
                default:
                    $title = ucfirst($name);
            }

            $icon = Html::tag('span', '', ['class' => "fa fa-$iconName"]);
            $options = array_merge([
                'title' => $title,
                'aria-label' => $title,
                'data-pjax' => '0',
            ], $additionalOptions);
            $icon = Html::tag('span', '', ['class' => "fa fa-$iconName"]);
            $entity_id = isset($_GET['id'])? (int)$_GET['id'] : null;
            static::$buttons .= Html::a($icon, [$name, 'id' => $entity_id], $options) . ' ';
        };
    }


}

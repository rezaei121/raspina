<?php

namespace app\modules\post\models;

use Yii;

/**
 * This is the model class for table "{{%post_tag}}".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $tag_id
 *
 * @property Post $post
 * @property Tag $tag
 */
class PostTag extends \app\modules\post\models\base\BasePostTag
{

}

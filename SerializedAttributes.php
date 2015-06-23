<?php

namespace baibaratsky\yii\behaviors\model;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

/**
 * Class SerializedAttributes
 * @package baibaratsky\yii\behaviors\model
 *
 * @property BaseActiveRecord $owner
 */
class SerializedAttributes extends Behavior
{
    public $attributes = [];

    private $oldAttributes = [];

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'serializeAttributes',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'serializeAttributes',

            BaseActiveRecord::EVENT_AFTER_INSERT => 'deserializeAttributes',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'deserializeAttributes',
            BaseActiveRecord::EVENT_AFTER_FIND => 'deserializeAttributes',
        ];
    }

    public function serializeAttributes()
    {
        foreach ($this->attributes as $attribute) {
            $this->owner->setOldAttribute($attribute, $this->oldAttributes[$attribute]);

            if (is_array($this->owner->$attribute) && count($this->owner->$attribute) > 0) {
                $this->owner->$attribute = serialize($this->owner->$attribute);
            } elseif (empty($this->owner->$attribute)) {
                $this->owner->$attribute = null;
            } else {
                throw new SerializeAttributeException($this->owner, $attribute);
            }
        }
    }

    public function deserializeAttributes()
    {
        foreach ($this->attributes as $attribute) {
            $this->oldAttributes[$attribute] = $this->owner->getOldAttribute($attribute);

            if (empty($this->owner->$attribute)) {
                $this->owner->setAttribute($attribute, []);
                $this->owner->setOldAttribute($attribute, []);
            } elseif (is_scalar($this->owner->$attribute)) {
                $value = @unserialize($this->owner->$attribute);
                if ($value !== false) {
                    $this->owner->setAttribute($attribute, $value);
                    $this->owner->setOldAttribute($attribute, $value);
                } else {
                    throw new DeserializeAttributeException($this->owner, $attribute);
                }
            }
        }
    }
}
<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FieldSetting Entity
 *
 * @property int $field_setting_id
 * @property string $field_setting_type
 * @property string $field_setting_name
 * @property string|null $field_setting_content
 * @property string|null $field_setting_image_path
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_upated
 */
class FieldSetting extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'field_setting_type' => 1,
        'field_setting_name' => 1,
        'field_setting_content' => 1,
        'field_setting_image_path' => 1,
        'time_created' => 1,
        'time_upated' => 1,
    ];
}

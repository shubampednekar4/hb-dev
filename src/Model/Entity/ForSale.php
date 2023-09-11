<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ForSale Entity
 *
 * @property int $for_sale_id
 * @property int|null $franchise_id
 * @property bool|null $published
 * @property string|null $user_coding_header
 * @property string|null $for_sale_name
 * @property string|null $for_sale_overview
 * @property string|null $for_sale_whb
 * @property string|null $for_sale_vitals
 * @property string|null $for_sale_map
 * @property string|null $for_sale_emails
 * @property string|null $for_sale_required
 * @property string|null $for_sale_img_path
 * @property string|null $custom_header
 * @property string|null $custom_text
 * @property string|null $for_sale_banner_text
 * @property \Cake\I18n\FrozenTime|null $time_created
 * @property \Cake\I18n\FrozenTime|null $time_updated
 *
 * @property \App\Model\Entity\Franchise|null $franchise
 */
class ForSale extends Entity
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
        'franchise_id' => 1,
        'published' => 1,
        'user_coding_header' => 1,
        'for_sale_name' => 1,
        'for_sale_overview' => 1,
        'for_sale_whb' => 1,
        'for_sale_vitals' => 1,
        'for_sale_map' => 1,
        'for_sale_emails' => 1,
        'for_sale_required' => 1,
        'for_sale_img_path' => 1,
        'custom_header' => 1,
        'custom_text' => 1,
        'for_sale_banner_text' => 1,
        'time_created' => 1,
        'time_updated' => 1,
        'franchise' => 1,
    ];
}

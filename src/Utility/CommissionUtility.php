<?php

namespace App\Utility;

use Automattic\WooCommerce\Client;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\ORM\Locator\LocatorAwareTrait;

class CommissionUtility
{
    use LocatorAwareTrait;

    /**
     * @var \Automattic\WooCommerce\Client
     */
    private Client $client;

    private array|\stdClass $terms;

    public const DEFAULT_SUM = 0.0;

    public function __construct()
    {
        $this->client = new Client(Configure::read('WooCommerce.uri'), Configure::read('WooCommerce.consumer_key'), Configure::read('WooCommerce.consumer_secret'));
        $this->terms =  $this->client->get("products/attributes/1/terms");
    }

    /**
     * @param $product_id
     *
     * @return float
     */
    public function getCommissionRate($product): float
    {
        if (!empty($product->attributes)) {
            foreach ($product->attributes as $attribute) {
                if ($attribute->name === 'Commission Category') {
                    foreach ($this->terms as $term) {
                        if ($attribute->options[0] === $term->name) {
                            $term_id = $term->id;
                            $rate_results = $this->getTableLocator()->get('Rates')->find()->where(['term_id' => $term_id]);
                            if ($rate_results->count()) {
                                $rate = $rate_results->first();
                                return $rate->rate_amount;
                            }
                        }
                    }
                }
            }
        }
        return 0.0;
    }

    /**
     * Commission Total
     *
     * @param $order_id
     * @return float
     */
    public function getCommissionTotal($order_id): float
    {
        $order = $this->client->get("orders/$order_id");
        $line_items = $order->line_items;
        $line_items = json_decode(json_encode($line_items), true);
        $ids = [];
        foreach ($line_items as $item) {
            $ids[] = $item['product_id'];
        }
        $item_collection = new Collection($line_items);
        $data = [
            'include' => $ids,
            'per_page' => 50,
        ];
        $products = $this->client->get('products', $data);
        $sum = self::DEFAULT_SUM;
        foreach ($products as $product) {
            $id = $product->id;
            $conditions = ['product_id' => $id];
            $product_record = $item_collection->firstMatch($conditions);
            $commission = $product_record['subtotal'] * $this->getCommissionRate($product);
            $sum += $commission;
        }
        return $sum;
    }
}
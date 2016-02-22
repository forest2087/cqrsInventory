<?php

namespace App\Services;


use Illuminate\Database\Eloquent\Model;
use App\Item;

use Carbon\Carbon;

/**
 * Class ItemQueryService
 *
 * @package App\Services
 */
class ItemQueryService {

    /**
     * @var Item
     */
    protected $model;

    /**
     * @param Item $model
     */
    public function __construct(Item $model)
    {
        $this->model = $model;
    }

    /**
     * return active items
     * @return items
     */
    public function get() {
        $items = $this->getAll();
        $result = [];
        foreach ($items as $item) {
            if ($item['event']=='add') {
                unset($item['event']);
                $result[$item['itemID']] = $item;
            } elseif ($item['event']=='remove') {
                unset($result[$item['itemID']]);
            }
        }
        //remove expired items
        foreach($result as $key=>$item) {
            if ($item->expire_at <= Carbon::now()) {
                unset($result[$key]);
            }
        }
        return $result;
    }

    /**
     * get all items without filter
     * @return items
     */
    public function getAll() {
        return $this->model->orderBy('created_at')->get();
    }
}

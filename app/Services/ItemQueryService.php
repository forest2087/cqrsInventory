<?php

namespace App\Services;


use Illuminate\Database\Eloquent\Model;
use App\Item;

use Carbon\Carbon;

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

    public function get() {
        $items = $this->getAllNotExpired();
        $result = [];
        foreach ($items as $item) {
            if ($item['event']=='add') {
                unset($item['event']);
                $result[$item['itemID']] = $item;
            } elseif ($item['event']=='remove') {
                unset($result[$item['itemID']]);
            }
        }
        return $result;
    }

    public function getAllNotExpired() {
        return $this->model->where('expire_at', '>', Carbon::now())->orderBy('created_at')->get();
    }

    public function getAll() {
        return $this->model->orderBy('created_at')->get();
    }
}

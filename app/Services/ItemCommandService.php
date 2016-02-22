<?php

namespace App\Services;


use App\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

/**
 * Class ItemCommandService
 *
 * @package App\Services
 */
class ItemCommandService {


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
     * store inventory events
     *
     * @param Request $request
     *
     * @return bool
     * @throws \Exception
     */
    function store(Request $request) {
        $item = $this->model->newInstance();
        if (!$request->itemID) {
            $item->itemID = Uuid::generate();
        } else {
            $item->itemID = $request->itemID;
        }
        $item->label = $request->label;
        $item->type = $request->type;
        $item->event = $request->event;
        $item->expire_at = Carbon::now()->addSecond($request->expire_at);

        return $item->save();
    }
}

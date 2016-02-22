<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\ItemCommandService;
use App\Services\ItemQueryService;

/**
 * Class ItemController
 *
 * @package App\Http\Controllers
 */
class ItemController extends Controller
{

    /**
     * @var ItemCommandService
     */
    protected $itemCommandService;

    /**
     * @var ItemQueryService
     */
    protected $itemQueryService;

    /**
     * ItemController constructor.
     *
     * @param ItemCommandService $itemCommandService
     * @param ItemQueryService   $itemQueryService
     */
    public function __construct(ItemCommandService $itemCommandService, ItemQueryService $itemQueryService) {
        $this->itemCommandService = $itemCommandService;
        $this->itemQueryService = $itemQueryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->itemQueryService->get();
        return response()->json(['items'=> $items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->itemCommandService->store($request);
        dd($result);
        return response()->json(['item received']);
    }

    /**
     * show all events
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = $this->itemQueryService->getAll();
        return response()->json(['items'=> $items]);
    }

}

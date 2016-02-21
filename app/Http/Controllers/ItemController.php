<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\ItemCommandService;
use App\Services\ItemQueryService;


class ItemController extends Controller
{

    protected $itemCommandService;

    protected $itemQueryService;

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
//        dd(gettype($items));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}

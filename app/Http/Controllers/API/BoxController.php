<?php

namespace App\Http\Controllers\API;

use App\Models\Box;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewBoxRequest;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxes = Box::has('products') // Only boxes with at least one product will be shown.
                    ->get()
                    ->append(['content', 'price']); // Content and price have to be appended to every box.

        return response()->json([
            'data' => $boxes
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\NewBoxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewBoxRequest $request)
    {
        $box = Box::create([
            'discount' => $request->discount,
        ]);

        return response()->json([
            'message' => 'Box created',
            'data'    => $box
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Box $box
     * @return \Illuminate\Http\Response
     */
    public function show(Box $box)
    {
        // Content and price have to be appended to the box.
        $box->append(['content', 'price']);

        return response()->json([
            'data' => $box
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Box $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        $box->delete();

        return response()->json([
            'message' => 'Box deleted',
        ], 201);
    }
}

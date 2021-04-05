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
    public function index(Request $request)
    {
        $boxes = Box::when($request->empty_boxes === 'false', function ($boxes) {
            return $boxes->has('products'); // Only boxes with at least one product will be shown.
        })
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
            'message' => "Box created with id $box->id",
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
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\NewProductRequest;  $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(NewBoxRequest $request, Box $box)
    {
        $box->discount = (int) $request->discount;

        $box->save();

        return response()->json([
            'message' => "Box with id $box->id updated",
            'data'    => $box
        ], 201);
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
            'message' => "Box with id $box->id deleted",
        ], 201);
    }
}

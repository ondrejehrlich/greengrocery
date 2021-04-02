<?php

namespace App\Http\Controllers\API;

use App\Models\Box;
use App\Models\Product;
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
     * @param  \Illuminate\Http\Request  $request
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

    /**
     * Add product to the box.
     *
     * @param Box $box
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function addProductToBox(Box $box, Product $product)
    {
        if ($product->stock > 0) {
            $product->decrement('stock');
            $product->save();
            $box->products()->attach($product->id);

            return response()->json([
                'message' => 'Product added to box number: ' . $box->id,
            ], 201);
        }

        return response()->json([
            'message' => 'Out of stock',
        ], 200);
    }
}

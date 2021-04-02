<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewProductRequest;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Search queries
        $nameSearch     = $request->name_search ?? '';
        $idSearch       = $request->id_search ?? '';
        $supplierSearch = $request->supplier_search ?? '';

        // If filter only products in stock
        $inStock = $request->in_stock === 'true' ? true : false;

        // Order by. Default is id.
        $orderBy = $request->order_by == 'last_edit' ? 'updated_at' : 'id';

        // How many product on one page.
        $perPage = 5;

        $products = Product::with('supplier')

                    // Search by name.
                    ->when($nameSearch, function ($products, $nameSearch) {
                        return $products->where('name', 'like', '%' . $nameSearch . '%');
                    })

                    // Search by id.
                    ->when($idSearch, function ($products, $idSearch) {
                        return $products->where('id', $idSearch);
                    })

                    // Search by supplier
                    ->when($supplierSearch, function ($products, $supplierSearch) {
                        return $products->whereHas(
                            'supplier',
                            function (Builder $query) use ($supplierSearch) {
                                $query->where('name', 'like', '%' . $supplierSearch . '%');
                            }
                        );
                    })

                    // Filter only products in stock.
                    ->when($inStock, function ($products, $inStock) {
                        return $products->where('stock', '>', 0);
                    })

                    // Order by.
                    ->orderBy($orderBy, 'asc')

                    // Pagination.
                    ->paginate($perPage)

                    // Append query string to pagination links
                    ->appends(request()->except(['page', '_token']));

        return response()->json([
            'data' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewProductRequest $request)
    {
        $product = new Product;

        $product->name        = $request->name;
        $product->price       = (float) $request->price;
        $product->stock       = (int) $request->stock;
        $product->supplier_id = $request->supplier_id;

        // Image upload
        if ($request->file) {
            $fileName       = time() . '_' . $request->file->getClientOriginalName();
            $filePath       = $request->file('file')->storeAs('productImages', $fileName);
            $product->image = '/productImages/' . $filePath;
        }

        $product->save();

        return response()->json([
            'message' => 'Product created',
            'data'    => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load('supplier:id,name');
        $product->load('boxes:id');

        return response()->json([
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->name        = $request->name;
        $product->price       = (float) $request->price;
        $product->stock       = (int) $request->stock;
        $product->supplier_id = $request->supplier_id;

        // Image upload
        if ($request->file) {
            $fileName       = time() . '_' . $request->file->getClientOriginalName();
            $filePath       = $request->file('file')->storeAs('productImages', $fileName);
            $product->image = '/productImages/' . $filePath;
        }

        $product->save();

        return response()->json([
            'message' => 'Product updated',
            'data'    => $product
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted'
        ], 201);
    }
}

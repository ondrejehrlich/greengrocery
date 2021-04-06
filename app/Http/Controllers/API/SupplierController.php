<?php

namespace App\Http\Controllers\API;

use App\Models\Supplier;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();

        return response()->json([
            'data' => $suppliers
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Sales;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $data['inventories'] = Inventory::all();
        if ($request->ajax()) {
            $data = Sales::with('inventory')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->inventory->name;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editSale">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteSale">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('apps.sales.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $inventory = Inventory::find($request->inventory_id);
        if ($request->quantity > $inventory->stock) {
            return response()->json(['error' => 'Insufficient stock available.'], 400);
        }

        $sale = Sales::create([
            'inventory_id' => $request->inventory_id,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        // Update inventory stock
        $inventory->stock -= $request->quantity;
        $inventory->save();

        return response()->json(['success' => 'Sale saved successfully.']);
    }

    public function edit($id)
    {
        $sale = Sales::find($id);
        return response()->json($sale);
    }

    public function destroy($id)
    {
        $sale = Sales::find($id);
        $inventory = $sale->inventory;
        $inventory->stock += $sale->quantity;
        $inventory->save();
        $sale->delete();

        return response()->json(['success' => 'Sale deleted successfully.']);
    }
}

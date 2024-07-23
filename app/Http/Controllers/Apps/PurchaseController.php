<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $data['inventories'] = Inventory::all();
        if ($request->ajax()) {
            $data = Purchase::with('inventory')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->inventory->name;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPurchase">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePurchase">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('apps.purchase.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $inventory = Inventory::find($request->inventory_id);

        $purchase = Purchase::create([
            'inventory_id' => $request->inventory_id,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        // Update inventory stock
        $inventory->stock += $request->quantity;
        $inventory->save();

        return response()->json(['success' => 'Purchase saved successfully.']);
    }

    public function edit($id)
    {
        $purchase = Purchase::find($id);
        return response()->json($purchase);
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $inventory = $purchase->inventory;
        $inventory->stock -= $purchase->quantity;
        $inventory->save();
        $purchase->delete();

        return response()->json(['success' => 'Purchase deleted successfully.']);
    }
}

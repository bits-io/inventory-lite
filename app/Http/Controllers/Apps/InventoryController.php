<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Inventory::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editInventory">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteInventory">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('apps.inventory.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        Inventory::updateOrCreate(['id' => $request->inventory_id],
                ['name' => $request->name, 'price' => $request->price, 'stock' => $request->stock]);

        return response()->json(['success'=>'Inventory saved successfully.']);
    }

    public function edit($id)
    {
        $inventory = Inventory::find($id);
        return response()->json($inventory);
    }

    public function destroy($id)
    {
        Inventory::find($id)->delete();
        return response()->json(['success'=>'Inventory deleted successfully.']);
    }
}

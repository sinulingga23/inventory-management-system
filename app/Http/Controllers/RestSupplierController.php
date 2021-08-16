<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;

class RestSupplierController extends Controller
{
    public function serverSideProcessing(Request $request)
    {
        if ($request->ajax())
        {
            // based on the table structure in the database
            $columns = array(
                0 => 'supplier_id',
                1 => 'supplier',
                2 => 'address',
                3 => 'created_at',
                4 => 'updated_at'
            );

            $recordsTotal = Supplier::count();
            $recordsFiltered = $recordsTotal;

            $length = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $suppliers = array();

            // check if the search value is not empty
            if (!empty($request->input('search.value')))
            {
                try
                {
                    $searchValue = $request->input('search.value');
                    $suppliers = Supplier::where('supplier_id', 'LIKE', "%{$searchValue}%")
                                ->orWhere('supplier', 'LIKE', "%{$searchValue}%")
                                ->offset($start)
                                ->limit($length)
                                ->orderBy($order, $dir)
                                ->get();
                    $recordsFiltered = $suppliers->count();
                }
                catch (\Exception $e)
                {
                    return response()->json([
                        'statusCode' => 500,
                        'message' => 'Somethings wrong!',
                        'errors' => $e->getMessage(),
                    ], 500);
                }
            }
            else
            {
                $suppliers = Supplier::offset($start)
                                ->limit($length)
                                ->orderBy($order, $dir)
                                ->get();
            }

            $data = array();
            if (!empty($suppliers))
            {
                foreach ($suppliers as $key => $supplier)
                {
                    $item['supplier_id'] = $supplier->supplier_id;
                    $item['supplier'] = $supplier->supplier;
                    $item['address'] = $supplier->address;
                    $item['created_at'] = date('d M Y', strtotime($supplier->created_at));

                    $item['updated_at'] = "";
                    if (!empty($supplier->updated_at))
                    {
                        $item['updated_at'] = date('d M Y', strtotime($supplier->updated_at));
                    }

                    $edit = '<a href="#"><i class="fas fa-edit edit-supplier" data-toggle="modal" data-target="#modal-edit-supplier" id="' . $supplier->supplier_id . '"></i></a>';
                    $delete = '<a href="#"><i class="fas fa-trash-alt delete-supplier" id="' . $supplier->supplier_id . '"></i></a>';
                    $item["options"] = $edit . '&emsp;' . $delete;
                    $data[] = $item;
                }
            }

            return response()->json(
                [
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => intval($recordsTotal),
                    'recordsFiltered' => intval($recordsFiltered),
                    'data' => $data,
                ]
                , 200);
        }
    }

    public function getSupplierBySupplierId($supplierId)
    {
        $pattern = '/^[0-9]+$/';
        if (!preg_match($pattern, $supplierId))
        {
            return response()->json([
                'statusCode' => 400,
                'message' => 'Request tidak valid.'
            ],400);
        }

        try
        {
            $supplier = Supplier::find($supplierId);
            if (empty($supplier)) {
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'Data tidak ditemukan.',
                ],404);
            }
        }
        catch (\Exception $e)
        {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Terjadi kesalahan.',
                'errors' => $e->getMessage(),
            ], 500);
        }


        return [
            'statusCode' => 200,
            'data' => new SupplierResource($supplier),
        ];
    }
}

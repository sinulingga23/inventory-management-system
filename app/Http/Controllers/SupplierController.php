<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('suppliers.index', [
            'suppliers' => Supplier::orderBy('supplier', 'ASC')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier-add-name' => 'required|string|max:150',
            'supplier-add-address' => 'required|string|max:200',
        ]);

        try
        {
            Supplier::create([
                'supplier' => $request->input('supplier-add-name'),
                'address' => $request->input('supplier-add-address'),
            ]);

            return redirect(route('suppliers.index'))->with([
                'success-add-supplier' => 'Berhasil menambahkan data.'
            ]);
        }
        catch (\Exception $e)
        {
            return redirect(route('suppliers.index'))->with([
                'failed-add-supplier' => 'Gagal menambah data. Errors: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $supplierId)
    {
        $request->validate([
            'supplier-edit-id' => 'required|integer|exists:suppliers,supplier_id',
            'supplier-edit-name' => 'required|string|max:150',
            'supplier-edit-address' => 'required|string|max:200',
        ]);

        $pattern = '/^[0-9]+$/';
        if (intval($request->input('supplier-edit-id')) != $supplierId || !preg_match($pattern, $supplierId))
        {
            return redirect(route('suppliers.index'))->with([
                'failed-updated-supplier' => 'Request tidak valid.',
            ]);
        }

        try
        {
            $currentSupplier = Supplier::find($supplierId);
            if ($currentSupplier != null)
            {
                $currentSupplier->update([
                    'supplier' => $request->input('supplier-edit-name'),
                    'address' => $request->input('supplier-edit-address'),
                ]);

                return redirect(route('suppliers.index'))->with([
                    'success-update-supplier' => 'Berhasil memperbaharui data.'
                ]);
            }
            else
            {
                return redirect(route('suppliers.index'))->with([
                    'failed-update-supplier' => 'Data tidak ditemukan',
                ]);
            }
        }
        catch (\Exception $e)
        {
            return redirect(route('suppliers.index'))->with([
                'failed-update-supplier' => 'Gagal memperbaharui data. Errros: ' . $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request, $supplierId)
    {
        $request->validate([
            'supplier-delete-id' => 'required|integer|exists:suppliers,supplier_id',
        ]);

        $pattern = '/^[0-9]+$/';
        if ($request->input('supplier-delete-id') != $supplierId || !preg_match($pattern, $supplierId))
        {
            return redirect(route('suppliers.index'))->with([
                'failed-delete-supplier' => 'Request tidak valid',
            ]);
        }

        try
        {
            $currentSupplier = Supplier::find($supplierId);
            if (!empty($currentSupplier))
            {
                $currentSupplier->delete();
            }
        }
        catch (\Exception $e) {
            return redirect(route('suppliers.index'))->with([
                'failed-delete-supplier' => 'Gagal menghpapus data. Errors: ' . $e->getMessage(),
            ]);
        }
    }
}

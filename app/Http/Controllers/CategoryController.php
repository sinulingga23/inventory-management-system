<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category-add-code' => 'required|string|max:150|unique:categories,code',
            'category-add-name' => 'required|string|max:150'
        ]);

        try
        {
            Category::create([
                'code' => $request->input('category-add-code'),
                'category' => $request->input('category-add-name'),
            ]);

            return redirect(route('categories.index'))->with([
                'success-add-category' => 'Berhasil menambah data.',
            ]);
        }
        catch (\Exception $e)
        {
            return redirect(route('categories.index'))->with([
                'falied-add-category' => 'Gagal Menambah Data. Errors: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * This function uses to update a category based on Id
     * @param Request $requset Contains request from client.
     * @param integer $categoryId The primary key of category
     */
    public function update(Request $request, $categoryId)
    {
        $request->validate([
            'category-update-code' => 'required|string|max:150|exists:categories,code',
            'category-update-name' => 'required|string|max:150',
            'category-update-id' => 'required|integer|exists:categories,category_id',
        ]);

        $pattern = '/^[0-9]+$/';
        if (intval($request->input('category-update-id')) != intval($categoryId) || !preg_match($pattern, $categoryId))
        {
            return redirect(route('categories.index'))-with([
                'failed-update-category' => 'Request tidak valid.',
            ]);
        }

        try
        {
            $currentCategory = Category::find($categoryId);
            if (!empty($currentCategory))
            {
                $currentCategory->update([
                    'code' => $request->input('category-update-code'),
                    'category' => $request->input('category-update-name'),
                ]);

                return redirect(route('categories.index'))->with([
                    'success-update-category' => 'Berhhasil memperbaharui data.',
                ]);
            }
            else
            {
                return redirect(route('categories.index'))->with([
                    'failed-update-category' => 'Data tidak ditemukan.',
                ]);
            }
        }
        catch (\Exception $e)
        {
            return redirect(route('categories.index'))->with([
                'failed-update-category' => 'Gagal memperbaharui data. Errors :' . $e->getMessage(),
            ]);
        }
    }

    /**
     * This function uses to delete a category based on Id
     * @param Request $request Contains request from client.
     * @param integer $categioryId The primary key of category.
     */
    public function destroy(Request $request, $categoryId)
    {
        $request->validate([
            'category-delete-id' => 'required|integer|exists:categories,category_id',
        ]);

        $pattern = '/^[0-9]+$/';
        if (intval($request->input('category-delete-id') != intval($categoryId) || !preg_match($pattern, $categoryId)))
        {
            return redirect(route('categories.index'))->with([
                'failed-delete-category' => 'Request tidak valid.'
            ]);
        }

        try
        {
            $currentCategory = Category::find($categoryId);
            if (!empty($currentCategory))
            {
                $currentCategory->delete();
                return redirect(route('categories.index'))->with([
                    'success-delete-category' => 'Berhasil menghapus data.',
                ]);
            }
        }
        catch (\Exception $e)
        {
            return redirect(route('categories.index'))->with([
                'failed-delete-category' => 'Gagal menghapus data. Errors: ' . $e->getMessage(),
            ]);
        }
    }
}

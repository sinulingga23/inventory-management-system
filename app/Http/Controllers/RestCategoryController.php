<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryResource;

class RestCategoryController extends Controller
{
    public function serverSideProcessing(Request $request)
    {
        // based on the table categories in the database, without deleted_at
        $columns = array(
            0 => 'category_id',
            1 => 'code',
            2 => 'category',
            3 => 'created_at',
            4 => 'updated_at',
        );

        $recordsTotal = Category::count();
        $recordsFiltered = $recordsTotal;

        $length = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $categories = array();

        // check if the search value is not empty
        if (!empty($request->input('search.value')))
        {
            try
            {
                $searchValue = $request->input('search.value');
                $categories = Category::where('category_id', 'LIKE', "%{$searchValue}%")
                            ->orWhere('code', 'LIKE', "%{$searchValue}%")
                            ->orWhere('category', 'LIKE', "%{$searchValue}%")
                            ->offset($start)
                            ->limit($length)
                            ->orderBy($order, $dir)
                            ->get();
                $recordsFiltered = $categories->count();
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
            $categories = Category::offset($start)
                        ->limit($length)
                        ->orderBy($order, $dir)
                        ->get();
        }

        $data = array();
        if (!empty($categories))
        {
            foreach ($categories as $key => $category)
            {
                $item['category_id'] = $category->category_id;
                $item['code'] = $category->code;
                $item['category'] = $category->category;
                $item['created_at'] = date('d M Y', strtotime($category->created_at));

                $item['updated_at'] = '';
                if (!empty($category->updated_at))
                {
                    $item['updated_at'] = date('d M Y', strtotime($category->updated_at));
                }

                $edit = '<a href="#"><i class="fas fa-edit edit-category" data-toggle="modal" data-target="#modal-update-category" id="' . $category->category_id . '"></i></a>';
                $delete = '<a href="#"><i class="fas fa-trash-alt delete-category" id="' . $category->category_id .'"></i></a>';
                $item['options'] = $edit . '&emsp;' . $delete;
                $data[] = $item;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsFiltered),
            'data' => $data,
        ],200);
    }

    /**
     * This function uses to check is already category or not
     * @param string $categoryCode Category code which will be checked.
     */
    public function isCategoryCodeExists($categoryCode)
    {
        if (empty($categoryCode))
        {
            return response()->json([
                'statusCode' => 400,
                'message' => 'Request tidak valid',
            ], 400);
        }

        $validator = Validator::make(['category-code' => $categoryCode], [
            'category-code' => 'required|string|exists:categories,code',
        ]);

        if (!$validator->fails())
        {
            return response()->json([
                'statusCode' => 200,
                'isExists' => true,
                'message' => 'Code ditemukan.'
            ],200);
        }
        else
        {
            return response()->json([
                'statusCode' => 404,
                'isExists' => false,
                'message' => 'Code tidak ditemukan.',
            ],404);
        }
    }

    /**
     * This function uses to get category based on Id
     * @param integer $categoryId The primary key of category.
     */
    public function getCategoryByCategoryId($categoryId)
    {
        $pattern = '/^[0-9]+$/';
        if (!preg_match($pattern, $categoryId))
        {
            return response()->json([
                'statusCode' => 400,
                'message' => 'Request tidak valid.',
            ],400);
        }

        $validator = Validator::make(['category-id' => $categoryId], [
            'category-id' => 'exists:categories,category_id'
        ]);

        // category is found
        if (!$validator->fails())
        {
            try
            {
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'Data ditemukan.',
                    'data' => new CategoryResource(Category::find($categoryId)),
                ], 200);
            }
            catch (\Exception $e)
            {
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'Terjadi kesalahan.',
                    'errors' => $e->getMessage(),
                ], 500);
            }
        }
        else // category is not found
        {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

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

                $edit = '<a href="#><i class="fas fa-edit edit-category" data-toggle="modal" data-target="modal-edit-category" id="' . $category->category_id . '"></i></a>';
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
}

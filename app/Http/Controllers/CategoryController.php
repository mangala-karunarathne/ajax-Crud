<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::select('id', 'name','type');
        if ($request->ajax()) {
            return DataTables::of($categories)
            ->addColumn('action', function($row){
               return '<a class="btn-sm btn btn-info editButton" data-id="'.$row->id.'">Edit</a>
               <a class="btn-sm btn btn-danger delButton" data-id="'.$row->id.'">Delete</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        if($request->category_id != null){
            $category = Category::find($request->category_id);
            if(! $category){
                abort(404);
            }
            $category->update([
                'name' => $request->name,
                'type' => $request->type,
            ]);
            return response()->json([
                'success' => 'Category Updated Successfully',
            ], 201);
        }else{

            $request->validate([
                'name' => 'required | min:2 | max: 100',
                'type' => 'required',
            ]);
            // dd($request->type);
            Category::create([
                'name' => $request->name,
                'type' => $request->type,
            ]);

            // return response()->json([
            //     'success' => 200
            // ]);

            return response()->json([
                'success' => 'Category Saved Successfully',
            ], 201);

        }

    }

    public function edit($id)
    {
       $category = Category::find($id);
       if(! $category) {
        abort(404);
       }
       return $category;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        if ($request->ajax()) {
            return DataTables::of($categories)
            ->addColumn('action', function($category){
               return '<a class="btn btn-info">Edit</a>';
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

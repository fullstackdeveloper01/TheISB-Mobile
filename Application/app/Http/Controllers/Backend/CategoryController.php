<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $categoryList = Category::where('parent_id', 0)->orderbyDesc('id')->paginate(12);
        return view('backend.categories.index', [
            'categories' => $categoryList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $createCategory = Category::create([
            'name' => $request->name,
            'parent_id' => 0,
        ]);

        if ($createCategory) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.categories.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('backend.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $status = ($request->has('status')) ? 1 : 0;

        $update = $category->update([
            'name' => $request->name,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }

    /**
     * Get user information on select change
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubCategory(Request $request)
    {
        $category_id = $request->id;
        $html = '';
        if($category_id)
        {
            $subCategoryRes = Category::select('id','name')->where('parent_id', $category_id)->get();
            if(count($subCategoryRes) >0 ){
                $html = $subCategoryRes;
            }
        }
        return response()->json([
            'data' => $html,
        ]);
    }
}

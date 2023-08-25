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

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $categoryList = Category::where('parent_id', '>', 0)->orderbyDesc('id')->paginate(12);
        return view('backend.sub-categories.index', [
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
        $categoryList = Category::where('parent_id', 0)->orderbyDesc('id')->get();
        return view('backend.sub-categories.create', ['categoryList' => $categoryList]);
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
            'name' => ['required', 'string', 'max:50'],
            'parent_id' => ['required']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $createCategory = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        if ($createCategory) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.subCategories.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Category $subCategory)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $subCategory)
    {
        $categoryList = Category::where('parent_id', 0)->orderbyDesc('id')->get();
        return view('backend.sub-categories.edit', [
            'category' => $subCategory,
            'categoryList' => $categoryList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $subCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'parent_id' => ['required']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $status = ($request->has('status')) ? 1 : 0;

        $update = $subCategory->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.subCategories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $subCategory)
    {
        $subCategory->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

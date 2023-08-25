<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Marina;
use App\Models\UserLog;
use App\Helpers\CustomHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $services = Service::orderbyDesc('id')->paginate(12);
        $marinaList = Marina::where('role', 1)->get();
        return view('backend.services.index', [
            'services' => $services,
            'marinaList' => $marinaList            
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
		$subCategoryList = Category::where('parent_id', '>', 0)->orderbyDesc('id')->get();
        $marinaList = Marina::where('role', 1)->get();
        return view('backend.services.create', ['marinaList' => $marinaList, 'categoryList' => $categoryList, 'subCategoryList' => $subCategoryList]);
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
            'service_name' => ['required', 'string', 'max:150'],
            'marina_id' => ['required'],
            'category_id' => ['required'],
            'sub_category_id' => ['required'],
            'distance' => ['required'],
            'address' => ['required'],
            'heading' => ['required'],
            'description' => ['required'],
            'contact_number' => ['required']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
		
		if ($request->has('service_icon')) {
            $service_icon = vImageUpload($request->file('service_icon'), 'images/services/', '110x110');
        } else {
            $service_icon = "images/services/no-image.png";
        }

        $createService = Service::create([
            'service_name' => $request->service_name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'distance' => $request->distance,
            'marina_id' => implode(',', $request->marina_id),
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'heading' => $request->heading,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'service_icon' => $service_icon,
            'status' => 1,
        ]);

        if ($createService) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.services.index');
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
    public function edit(Service $service)
    {
        $categoryList = Category::where('parent_id', 0)->orderbyDesc('id')->get();
        $subCategoryList = Category::where('parent_id', '>', 0)->orderbyDesc('id')->get();
        $marinaList = Marina::where('role', 1)->get();
        $selectedMarina = [];
        if(!empty($service->marina_id)){
            $selectedMarina = explode(',', $service->marina_id);
        }
        return view('backend.services.edit', [
            'service' => $service,
            'marinaList' => $marinaList,
            'categoryList' => $categoryList,
            'selectedMarina' => $selectedMarina,
            'subCategoryList' => $subCategoryList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => ['required', 'string', 'max:150'],
            'marina_id' => ['required'],
            'category_id' => ['required'],
            'sub_category_id' => ['required'],
            'distance' => ['required'],
            'address' => ['required'],
            'heading' => ['required'],
            'description' => ['required'],
            'contact_number' => ['required']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $status = ($request->has('status')) ? 1 : 0;
		
		if($request->has('service_icon')) {
            $service_icon = vImageUpload($request->file('service_icon'), 'images/services/', '110x110', null, $service->service_icon);
        } else {
            $service_icon = $service->service_icon;
        }

        $update = $service->update([
            'service_name' => $request->service_name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'distance' => $request->distance,
            'marina_id' => implode(',', $request->marina_id),
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'heading' => $request->heading,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'service_icon' => $service_icon,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.services.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if ($service->service_icon != "images/services/no-image.png") {
            removeFile($service->service_icon);
        }
        $service->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Country;
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

class AmenitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $amenityList = Amenity::orderbyDesc('id')->paginate(15);
        return view('backend.amenities.index', [
            'amenityList' => $amenityList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.amenities.create');
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
            'amenity' => ['required', 'unique:amenities', 'string', 'max:100'],
            'icon' => 'required|mimes:png,jpg,jpeg|max:1024'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        if ($request->has('icon')) {
            $icon = vImageUpload($request->file('icon'), 'images/amenities/', '110x110');
        } else {
            $icon = "images/amenities/no-icon.png";
        }
        $createAmenity = Amenity::create([
            'amenity' => $request->amenity,
            'icon' => $icon
        ]);

        if ($createAmenity) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.amenities.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Amenity $amenity)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Amenity $amenity)
    {
        return view('backend.amenities.edit', [
            'amenity' => $amenity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amenity $amenity)
    {
        $validator = Validator::make($request->all(), [
            'amenity' => ['required', 'string', 'max:100']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $status = ($request->has('status')) ? 1 : 0;
        if ($request->has('icon')) {
            $icon = vImageUpload($request->file('icon'), 'images/amenities/', '110x110', null, $amenity->icon);
        } else {
            $icon = $amenity->icon;
        }
        $update = $amenity->update([
            'amenity' => $request->amenity,
            'icon' => $icon,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.amenities.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

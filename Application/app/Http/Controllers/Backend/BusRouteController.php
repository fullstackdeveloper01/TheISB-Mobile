<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BusRoute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class BusRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $busRoute = BusRoute::where('id', 2)->first();
		return view('backend.bus-route.edit', [
            'busRoute' => $busRoute,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.advertise.create', []);
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
            'title' => ['required']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
		
		if ($request->has('image')) {
            $image = vImageUpload($request->file('image'), 'images/splash-screen/', '110x110');
        } else {
            $image = "images/splash-screen/no-image.png";
        }

        $createadvertisement = BusRoute::create([
            'title' => $request->title,
            'image' => $image,
            'status' => 1,
        ]);

        if ($createadvertisement) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.advertisement.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(BusRoute $advertisement)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(BusRoute $advertisement)
    {
        return view('backend.advertise.edit', [
            'advertisement' => $advertisement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusRoute $busRoute)
    {
		$validator = Validator::make($request->all(), [
            'image' => 'mimes:pdf,PDF|max:12288'
        ],
        ['image.max'=> 'File must not be greater than 12MB']
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $status = ($request->has('status')) ? 1 : 0;
		
		if($request->has('image')) {
            $image = vFileUpload($request->file('image'), 'images/bus-routes/', null, null, $busRoute->image);
        } else {
            $image = $busRoute->image;
        }

        $update = $busRoute->update([
            'image' => $image,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.busRoute.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusRoute $busRoute)
    {
        if ($advertisement->image != "images/advertisement/no-image.png") {
            removeFile($advertisement->image);
        }
        $advertisement->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class AdvertisementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $advertisements = Advertise::orderbyDesc('id')->paginate(12);
        return view('backend.advertise.index', [
            'advertisements' => $advertisements
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
            $image = vImageUpload($request->file('image'), 'images/advertisements/', null);
        } else {
            $image = "images/advertisement/no-image.png";
        }

        $createadvertisement = Advertise::create([
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
    public function show(Advertise $advertisement)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertise $advertisement)
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
    public function update(Request $request, Advertise $advertisement)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $status = ($request->has('status')) ? 1 : 0;
		
		if($request->has('image')) {
            $image = vImageUpload($request->file('image'), 'images/advertisement/', null, null, $advertisement->image);
        } else {
            $image = $advertisement->image;
        }

        $update = $advertisement->update([
            'title' => $request->title,
            'image' => $image,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.advertisement.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertise $advertisement)
    {
        if ($advertisement->image != "images/advertisement/no-image.png") {
            removeFile($advertisement->image);
        }
        $advertisement->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

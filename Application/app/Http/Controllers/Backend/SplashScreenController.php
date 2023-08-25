<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SplashScreen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class SplashScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $splashScreen = SplashScreen::where('id', 1)->first();
		return view('backend.splash-screen.edit', [
            'splashScreen' => $splashScreen,
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

        $createadvertisement = SplashScreen::create([
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
    public function show(SplashScreen $advertisement)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(SplashScreen $advertisement)
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
    public function update(Request $request, SplashScreen $splashScreen)
    {
        $status = ($request->has('status')) ? 1 : 0;
		
		if($request->has('image')) {
            $image = vImageUpload($request->file('image'), 'images/splash/', '110x110', null, $splashScreen->image);
        } else {
            $image = $splashScreen->image;
        }

        $update = $splashScreen->update([
            'image' => $image,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.splashScreen.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(SplashScreen $splashScreen)
    {
        if ($advertisement->image != "images/advertisement/no-image.png") {
            removeFile($advertisement->image);
        }
        $advertisement->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IntroScreen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class IntroScreensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $introScreensList = IntroScreen::orderbyDesc('id')->paginate(15);
        return view('backend.intro-screens.index', [
            'introScreensList' => $introScreensList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.intro-screens.create', []);
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
		
		if ($request->has('screen')) {
            $screen = vImageUpload($request->file('screen'), 'images/intro-screens/', '110x110');
        } else {
            $screen = "images/intro-screens/no-image.png";
        }

        $createaintroScreen = IntroScreen::create([
            'title' => $request->title,
            'screen' => $screen,
            'status' => 1,
        ]);

        if ($createaintroScreen) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.introScreens.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(IntroScreen $introScreen)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(IntroScreen $introScreen)
    {
        return view('backend.intro-screens.edit', [
            'introScreen' => $introScreen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntroScreen $introScreen)
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
		
		if($request->has('screen')) {
            $screen = vImageUpload($request->file('screen'), 'images/intro-screens/', '110x110', null, $introScreen->screen);
        } else {
            $screen = $introScreen->screen;
        }

        $update = $introScreen->update([
            'title' => $request->title,
            'screen' => $screen,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.introScreens.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntroScreen $introScreen)
    {
        if ($introScreen->screen != "images/intro-screens/no-image.png") {
            removeFile($introScreen->screen);
        }
        $introScreen->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

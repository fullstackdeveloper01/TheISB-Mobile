<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Validator;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sliderList = Slider::orderbyDesc('id')->get();
        return view('backend.sliders.index', [
            'sliders' => $sliderList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sliders.create');
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
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'redirection' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $uploadImage = vImageUpload($request->file('image'), 'images/sliders/', null);
        if ($uploadImage) {
            $create = Slider::create([
                'title' => $request->title,
                'image' => $uploadImage,
                'redirection' => $request->redirection,
            ]);
            if ($create) {
                toastr()->success(__('Created Successfully'));
                return redirect()->route('admin.sliders.index');
            }
        } else {
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('backend.sliders.edit', ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'image' => ['mimes:png,jpg,jpeg', 'max:2048'],
            'redirection' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if ($request->has('image')) {
            $uploadImage = vImageUpload($request->file('image'), 'images/sliders/', null, null, $slider->image);
        } else {
            $uploadImage = $slider->image;
        }
        if ($uploadImage) {
            $update = $slider->update([
                'title' => $request->title,
                'image' => $uploadImage,
                'redirection' => $request->redirection,
            ]);
            if ($update) {
                toastr()->success(__('Updated Successfully'));
                return redirect()->route('admin.sliders.index');
            }
        } else {
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        removeFile($slider->image);
        $slider->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

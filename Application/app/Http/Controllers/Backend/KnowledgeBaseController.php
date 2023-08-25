<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;
use Validator;

class KnowledgeBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $knowledgeBaseList = KnowledgeBase::orderbyDesc('id')->get();
        return view('backend.knowledge-base.index', [
            'knowledgeBaseList' => $knowledgeBaseList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.knowledge-base.create');
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
            'content' => ['required'],
            'short_description' => ['required', 'string', 'max:200', 'min:2'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $uploadImage = vImageUpload($request->file('image'), 'images/knowledge-base/', null);
        if ($uploadImage) {
            $create = KnowledgeBase::create([
                'title' => $request->title,
                'image' => $uploadImage,
                'content' => $request->content,
                'short_description' => $request->short_description,
            ]);
            if ($create) {
                toastr()->success(__('Created Successfully'));
                return redirect()->route('admin.knowledgeBase.index');
            }
        } else {
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeBase  $knowledgeBase
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeBase $knowledgeBase)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeBase  $knowledgeBase
     * @return \Illuminate\Http\Response
     */
    public function edit(KnowledgeBase $knowledgeBase)
    {
        return view('backend.knowledge-base.edit', ['knowledgeBase' => $knowledgeBase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeBase  $knowledgeBase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KnowledgeBase $knowledgeBase)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'image' => ['mimes:png,jpg,jpeg', 'max:2048'],
            'content' => ['required'],
            'short_description' => ['required', 'string', 'max:200', 'min:2'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if ($request->has('image')) {
            $uploadImage = vImageUpload($request->file('image'), 'images/knowledge-base/', null, null, $knowledgeBase->image);
        } else {
            $uploadImage = $knowledgeBase->image;
        }
        if ($uploadImage) {
            $update = $knowledgeBase->update([
                'title' => $request->title,
                'image' => $uploadImage,
                'content' => $request->content,
                'short_description' => $request->short_description,
            ]);
            if ($update) {
                toastr()->success(__('Updated Successfully'));
                return redirect()->route('admin.knowledgeBase.index');
            }
        } else {
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeBase  $knowledgeBase
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeBase $knowledgeBase)
    {
        removeFile($knowledgeBase->image);
        $knowledgeBase->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

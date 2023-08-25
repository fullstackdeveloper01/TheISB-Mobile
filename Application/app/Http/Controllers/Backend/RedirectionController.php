<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Redirection;
use Illuminate\Http\Request;
use Validator;

class RedirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $redirections = Redirection::orderbyDesc('id')->get();
        return view('backend.redirections.index', [
            'redirections' => $redirections
        ]);
    }

	/*************************************************************
	*@Create Slug
	**************************************************************/
	function createSlug($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.redirections.create');
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
            'title' => ['required', 'string', 'max:255', 'min:2', 'unique:redirections']
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
		$create = Redirection::create([
			'title' => $request->title,
			'slug' => strtolower($this->createSlug($request->title)),
		]);
		if ($create) {
			toastr()->success(__('Created Successfully'));
			return redirect()->route('admin.redirection.index');
		}
		else {
            toastr()->error(__('Create error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Redirection  $redirection
     * @return \Illuminate\Http\Response
     */
    public function show(Redirection $redirection)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Redirection  $redirection
     * @return \Illuminate\Http\Response
     */
    public function edit(Redirection $redirection)
    {
        return view('backend.redirections.edit', ['redirection' => $redirection]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Redirection  $redirection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Redirection $redirection)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:2'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $status = ($request->has('status')) ? 1 : 0;
		$update = $redirection->update([
			'title' => $request->title,
            'status' => $status,
		]);
		if ($update) {
			toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.redirection.index');
		}
		return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Redirection  $redirection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirection $redirection)
    {
        $redirection->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

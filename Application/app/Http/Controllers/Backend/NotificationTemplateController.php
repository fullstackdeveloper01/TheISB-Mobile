<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class NotificationTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $notificationList = NotificationTemplate::orderbyDesc('id')->get();
        return view('backend.notification-template.index', [
            'notificationList' => $notificationList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.notification-template.create');
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
            'title' => ['required', 'max:150'],
            'message' => ['required', 'max:500']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $createtitle = NotificationTemplate::create([
            'title' => $request->title,
            'message' => $request->message
        ]);

        if ($createtitle) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.notificationTemplate.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationTemplate $notificationTemplate)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationTemplate $notificationTemplate)
    {
        return view('backend.notification-template.edit', [
            'notification' => $notificationTemplate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationTemplate $notificationTemplate)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:150'],
            'message' => ['required', 'max:500']
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $status = ($request->has('status')) ? 1 : 0;        
        $update = $notificationTemplate->update([
            'title' => $request->title,
            'message' => $request->message,
            'status' => $status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.notificationTemplate.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationTemplate $notificationTemplate)
    {
        $notificationTemplate->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

<?php

namespace App\Http\Controllers\Backend\Additional;

use App\Http\Controllers\Controller;
use App\Models\PopupNotice;
use Illuminate\Http\Request;

class PopupNoticeController extends Controller
{
    public function index()
    {
        $popupNotice = PopupNotice::where('id', 1)->first();
        return view('backend.additional.popup-notice', ['popupNotice' => $popupNotice]);
    }

    public function update(Request $request)
    {
        $request->popup_notice_status = ($request->has('popup_notice_status')) ? 1 : 0;
        $popupNotice = PopupNotice::where('id', 1)->first();
        if ($request->has('image')) {
            $uploadImage = vImageUpload($request->file('image'), 'images/popup-notice/', '1021x1600', null, $popupNotice->image);
        } else {
            $uploadImage = $popupNotice->image;
        }
        $popupNotice->status = $request->popup_notice_status;
        $popupNotice->image = $uploadImage;
        $popupNotice->save();
        toastr()->success(__('Updated Successfully'));
        return back();
    }
}

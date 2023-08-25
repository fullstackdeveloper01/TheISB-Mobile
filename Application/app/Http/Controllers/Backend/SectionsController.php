<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Section;
use App\Models\Redirection;
use App\Models\SectionOther;
use Illuminate\Http\Request;
use Validator;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$sectionList = Section::orderBy('sort_id', 'asc')->get();
		$idsArray = implode(',', $sectionList->pluck('id')->toArray());
		return view('backend.sections.index', [
			'sectionList' => $sectionList,
			'idsArray' => $idsArray
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sections.create');
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
            'title' => ['required', 'string', 'min:3', 'max:150'],
            /*'page' => ['required', 'boolean'],*/
            'bg_type' => ['required', 'boolean'],
            'section_type' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if($request->bg_type == 1){
            if ($request->has('image')) {
                $bg_value = vImageUpload($request->file('image'), 'images/sections/', null);
            } else {
                $bg_value = $section->bg_value;
            }
        }
        else{
            $bg_value = $request->bg_color;
        }
        $countLinks = Section::get()->count();
        $sortId = $countLinks + 1;
        $createMenu = Section::create([
            'page' => 0,
            'sort_id' => $sortId,
            'title' => $request->title,
            'title_color' => $request->title_color,
            'bg_type' => $request->bg_type,
            'bg_value' => $bg_value,
            'section_type' => $request->section_type,
        ]);
        if ($createMenu) {
            toastr()->success(__('Created Successfully'));
            return redirect(route('admin.sections.index'));
        }
    }

    /**
     *  Sort menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        $countLinks = Section::get()->count();
        if (!$countLinks) {
            toastr()->error(__('This menu is empty'));
            return back();
        }

        if ($request->has('ids')) {
            $arr = explode(',', $request->ids);
            foreach ($arr as $sortOrder => $id) {
                $menu = Section::find($id);
                $menu->sort_id = $sortOrder;
                $menu->save();
            }
            toastr()->success(__('Updated Successfully'));
            return back();
        } else {
            toastr()->error(__('Sorting error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        $sectionOther = SectionOther::where('section_id', $section->id)->get();
        $redirectionList = Redirection::where('status', 1)->get();
        return view('backend.sections.edit', ['section' => $section, 'sectionOther' => $sectionOther, 'redirectionList' => $redirectionList]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'bg_type' => ['required', 'boolean'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $status = ($request->has('status')) ? 1 : 0;
        if($request->bg_type == 1){
            if ($request->has('image')) {
                $bg_value = vImageUpload($request->file('image'), 'images/sections/', null);
            } else {
                $bg_value = $section->bg_value;
            }
        }
        else{
            $bg_value = $request->bg_color;
        }
        $line_color = '';
        $app_icon = '';
        $title_color = '';
        $sub_title = '';
        $sub_title_color = '';
        $btn_text_color = '';
        $btn_color = '';
        if($section->id == 2){
            if ($request->has('app_icon')) {
                $app_icon = vImageUpload($request->file('app_icon'), 'images/sections/', null);
            } else {
                $app_icon = $section->app_icon;
            }
            $line_color = $request->line_color;
        }
        $title_color = $request->title_color;
        if($section->id == 3 || $section->id == 7 || $section->id == 9){
            $sub_title = $request->sub_title;
            $sub_title_color = $request->sub_title_color;
        }
        if($section->id == 5){
            $btn_text_color = $request->btn_text_color;
            $btn_color = $request->btn_color;
        }
        $updateMenu = $section->update([
            'title' => $request->title,
            'bg_type' => $request->bg_type,
            'bg_value' => $bg_value,
            'status' => $status,
            'line_color' => $line_color,
            'app_icon' => $app_icon,
            'title_color' => $title_color,
            'sub_title' => $sub_title,
            'sub_title_color' => $sub_title_color,
            'btn_text_color' => $btn_text_color,
            'btn_color' => $btn_color,
        ]);
        if($section->id == 4){
            $sectionOtherData = SectionOther::select('id', 'icon')->where('section_id', $section->id)->get();
            if($sectionOtherData){
                foreach($sectionOtherData as $res){
                    if ($request->has('other_icon_'.$res->id)) {
                        $other_app_icon = vImageUpload($request->file('other_icon_'.$res->id), 'images/sections/', null);
                    } else {
                        $other_app_icon = $res->icon;
                    }
                    $other_title_           = $request->other_title_;
                    $other_box_color_       = $request->other_box_color_;
                    $other_title_color_     = $request->other_title_color_;
                    $other_redirection_     = $request->other_redirection_;
                    SectionOther::where('id', $res->id)->update([
                        'title'             => $other_title_[$res->id],
                        'box_color'         => $other_box_color_[$res->id],
                        'title_color'       => $other_title_color_[$res->id],
                        'redirection'       => $other_redirection_[$res->id],
                        'icon'              => $other_app_icon,
                    ]);
                }
            }
            if($request->hasfile('other_icon'))
            {
                $os = 0;
                $other_title        = $request->other_title;
                $other_title_color  = $request->other_title_color;
                $other_box_color    = $request->other_box_color;
                $redirection        = $request->other_redirection;
                foreach($request->file('other_icon') as $file)
                {
                    $uploadImage = vImageUpload($file, 'images/sections/', null);
                    if ($uploadImage) {
                        $create = SectionOther::create([
                            'section_id'        => $section->id,
                            'title'             => $other_title[$os],
                            'title_color'       => $other_title_color[$os],
                            'box_color'         => $other_box_color[$os],
                            'redirection'       => $redirection[$os],
                            'icon'              => $uploadImage,
                        ]);  
                        $os++;                      
                    }
                }
            }
        }
        if($section->id == 6){
            $sectionOtherData = SectionOther::select('id', 'icon')->where('section_id', $section->id)->get();
            if($sectionOtherData){
                foreach($sectionOtherData as $res){

                    if ($request->has('other_icon_'.$res->id)) {
                        $other_app_icon = vImageUpload($request->file('other_icon_'.$res->id), 'images/sections/', null);
                    } else {
                        $other_app_icon = $res->icon;
                    }
                    $other_title_           = $request->other_title_;
                    $other_title_color_     = $request->other_title_color_;
                    $other_sub_title_       = $request->other_sub_title_;
                    $other_sub_title_color_ = $request->other_sub_title_color_;
                    $other_icon_color_      = $request->other_icon_color_;
                    $btn_color_             = $request->other_btn_color_;
                    $other_redirection_     = $request->other_redirection_;
                    $other_redirection_url     = $request->other_redirection_url;
                    SectionOther::where('id', $res->id)->update([
                        'title'             => $other_title_[$res->id],
                        'title_color'       => $other_title_color_[$res->id],
                        'sub_title'         => $other_sub_title_[$res->id],
                        'sub_title_color'   => $other_sub_title_color_[$res->id],
                        'icon_color'        => $other_icon_color_[$res->id],
                        'btn_color'         => $btn_color_[$res->id],
                        'redirection'       => $other_redirection_[$res->id],
                        'redirection_url'       => $other_redirection_url[$res->id],
                        'icon'              => $other_app_icon,
                    ]);
                }
            }
            if($request->hasfile('other_icon'))
            {
                $os = 0;
                $other_title            = $request->other_title;
                $other_title_color      = $request->other_title_color;
                $other_sub_title        = $request->other_sub_title;
                $other_sub_title_color  = $request->other_sub_title_color;
                $icon_color             = $request->other_icon_color;
                $other_btn_color        = $request->other_btn_color;
                $redirection            = $request->other_redirection;
                $other_redirection_url     = $request->other_redirection_url_new;
                foreach($request->file('other_icon') as $file)
                {
                    $uploadImage = vImageUpload($file, 'images/sections/', null);
                    if ($uploadImage) {
                        $create = SectionOther::create([
                            'section_id'        => $section->id,
                            'title'             => $other_title[$os],
                            'title_color'       => $other_title_color[$os],
                            'sub_title'         => $other_sub_title[$os],
                            'sub_title_color'   => $other_sub_title_color[$os],
                            'icon_color'        => $icon_color[$os],
                            'btn_color'         => $other_btn_color[$os],
                            'redirection'       => $redirection[$os],
                            'redirection_url'       => $other_redirection_url[$os],
                            'icon'              => $uploadImage,
                        ]);  
                        $os++;                      
                    }
                }
            }
        }
        if($section->id > 10){
            $sectionOtherData = SectionOther::select('id', 'icon')->where('section_id', $section->id)->get();
            if($sectionOtherData){
                foreach($sectionOtherData as $res){
                    if ($request->has('other_icon_'.$res->id)) {
                        $other_app_icon = vImageUpload($request->file('other_icon_'.$res->id), 'images/sections/', null);
                    } else {
                        $other_app_icon = $res->icon;
                    }
                    $other_redirection_     = $request->other_redirection_;
                    $other_redirection_url_     = $request->other_redirection_url_;
                    SectionOther::where('id', $res->id)->update([
                        'redirection'       => $other_redirection_[$res->id],
                        'redirection_url'   => $other_redirection_url_[$res->id],
                        'icon'              => $other_app_icon,
                    ]);
                }
            }
            if($request->hasfile('other_icon'))
            {
                $os = 0;
                $redirection        = $request->other_redirection;
                $redirection_url    = $request->other_redirection_url;
                foreach($request->file('other_icon') as $file)
                {
                    $uploadImage = vImageUpload($file, 'images/sections/', null);
                    if ($uploadImage) {
                        $create = SectionOther::create([
                            'section_id'        => $section->id,
                            'redirection'       => $redirection[$os],
                            'redirection_url'       => $redirection_url[$os],
                            'icon'              => $uploadImage,
                        ]);  
                        $os++;                      
                    }
                }
            }
        }
        if ($updateMenu) {
            toastr()->success(__('Updated Successfully'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function deleteOtherSection(Request $request)
    {
        $id = $request->id;
        SectionOther::where('id', $id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }
}

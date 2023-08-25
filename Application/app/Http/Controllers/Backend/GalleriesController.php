<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Validator;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $galleryPhotosId = Gallery::where('item_type', 1)->pluck('id');
        $galleryVideosId = Gallery::where('item_type', 2)->pluck('id');
        $galleryPhotosList = GalleryItem::whereIn('gallery_id', $galleryPhotosId)->orderbyDesc('id')->get();
        $galleryVideosList = GalleryItem::whereIn('gallery_id', $galleryVideosId)->orderbyDesc('id')->get();
        $galleryPhotos = Gallery::where('item_type', 1)->get();
        $galleryVideos = Gallery::where('item_type', 2)->get();
        return view('backend.galleries.index', [
            'galleryPhotos' => $galleryPhotos,
            'galleryVideos' => $galleryVideos,
            'galleries' => $galleryPhotosList,
            'videoGalleries' => $galleryVideosList,
            'totalPhotos' => count($galleryPhotosList),
            'totalVideos' => count($galleryVideosList),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->item_type == 1){
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'item_photos' => ['required'],
                'item_photos.*' => ['mimes:jpeg,jpg,png,gif|max:2048'],
                'item_type' => ['required'],
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'item_videos' => ['required'],
                'item_type' => ['required'],
            ]);
        }
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $galleryCreate = Gallery::create([
                'title' => $request->title,
                'item_type' => $request->item_type,
            ]);
        if($request->item_type == 1){
            if($request->hasfile('item_photos'))
            {
                foreach($request->file('item_photos') as $file)
                { 
                    $uploadImage = vImageUpload($file, 'images/galleries/', null);
                    if ($uploadImage) {
                        $create = GalleryItem::create([
                            'gallery_id' => $galleryCreate->id,
                            'item_value' => $uploadImage,
                        ]);                        
                    }
                }
            }
        }
        else{
            $embed_code = $this->getYoutubeEmbedUrl($request->item_videos);
            if(!empty($embed_code)){
                $create = GalleryItem::create([
                    'gallery_id' => $galleryCreate->id,
                    'item_value' => $embed_code,
                ]);
            }
            else{
                toastr()->error(__('Please enter valid youtube url'));
                return back()->withInput();
            }
            /*if($request->hasfile('item_videos'))
            {
                foreach($request->file('item_videos') as $file)
                { 
                    $uploadImage = vFileUpload($file, 'images/galleries/');
                    if ($uploadImage) {
                    }
                }
            }*/
        }
        if ($galleryCreate) {
            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.galleries.index');
        }
        else{
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        return view('backend.galleries.edit', ['Gallery' => $gallery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
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
            $uploadImage = vImageUpload($request->file('image'), 'images/galleries/', null, null, $gallery->image);
        } else {
            $uploadImage = $gallery->image;
        }
        if ($uploadImage) {
            $update = $gallery->update([
                'title' => $request->title,
                'image' => $uploadImage,
                'content' => $request->content,
                'short_description' => $request->short_description,
            ]);
            if ($update) {
                toastr()->success(__('Updated Successfully'));
                return redirect()->route('admin.galleries.index');
            }
        } else {
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //removeFile($gallery->image);
        GalleryItem::where('gallery_id', $gallery->id)->delete();
        $gallery->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function setFeaturedImage(Request $request)
    {
        GalleryItem::where('id', '<>', $request->id)->update(['featured_status' => 0]);
        $galleryItem = GalleryItem::where('id', $request->id)->update(['featured_status' => 1]);
        return response()->json([
            'status' => true,
        ]);
    }
    
    function getYoutubeEmbedUrl($url)
    {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
        $youtube_id = '';
        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return $youtube_id;
    }
}

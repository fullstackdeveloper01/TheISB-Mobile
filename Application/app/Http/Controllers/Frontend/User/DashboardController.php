<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\UserLog;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Transfer;
use App\Models\MarinaPhotos;
use App\Models\MarinaAmenity;
use App\Models\MarinaDetail;
use App\Models\UserContactPersonal;
use Illuminate\Http\Request;
use Validator;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect()->route('user.dashboard');
    }

    protected function user()
    {
        $user = User::find(userAuthInfo()->id);
        $user['name'] = $user->firstname . ' ' . $user->lastname;
        return $user;
    }

    public function index(Request $request)
    {
        if ($request->input('search')) {
            $q = $request->input('search');
            $transfers = Transfer::where([['unique_id', 'like', '%' . $q . '%'], ['user_id', userAuthInfo()->id]])
                ->OrWhere([['link', 'like', '%' . $q . '%'], ['user_id', userAuthInfo()->id]])
                ->OrWhere([['sender_email', 'like', '%' . $q . '%'], ['user_id', userAuthInfo()->id]])
                ->OrWhere([['sender_name', 'like', '%' . $q . '%'], ['user_id', userAuthInfo()->id]])
                ->OrWhere([['emails', 'like', '%' . $q . '%'], ['user_id', userAuthInfo()->id]])
                ->OrWhere([['subject', 'like', '%' . $q . '%'], ['user_id', userAuthInfo()->id]])
                ->OrWhere([['message', 'like', '%' . $q . '%'], ['user_id', userAuthInfo()->id]])
                ->withCount('transferFiles')
                ->orderbyDesc('id')
                ->paginate(20);
            $transfers->appends(['q' => $q]);
        } else {
            $transfers = Transfer::where('user_id', userAuthInfo()->id)->withCount('transferFiles')->orderbyDesc('id')->paginate(20);
        }
        $totalTransfers = Transfer::where('user_id', userAuthInfo()->id)->count();
        $user = User::find(userAuthInfo()->id);
        return view('frontend.user.dashboard.index', ['user' => $user, 'transfers' => $transfers, 'totalTransfers' => $totalTransfers]);
    }

    public function marinasProfile(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        if($marinaId){
            $user = User::find(userAuthInfo()->id);
            $amenityID = array('15', '16', '17', '18');
            $amenities = Amenity::whereIn('id', $amenityID)->get();
            $marinaDetail = MarinaDetail::where('marina_id', userAuthInfo()->id)->first();
            $selectedAmenityList = MarinaAmenity::where(['marina_id' => $marinaId, 'featured_status' => 1])->pluck('amenity_id');
            $cityList = City::where('status', 1)->get();
            $featuredAmenity = [];
            foreach($selectedAmenityList as $rrr){
                array_push($featuredAmenity, $rrr);
            }
            return view('frontend.user.marinas.index', ['user' => $user, 'amenities' => $amenities, 'featuredAmenity' => $featuredAmenity, 'cityList' => $cityList, 'marinaDetail' => $marinaDetail]);
        }
        else{
            toastr()->error(__('Access denied'));
            return back();
        }
    }

    public function marinasProfileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:50'],
            'address_1' => ['required', 'string', 'max:255'],
            'city_id' => ['required'],
            'zip' => ['required'],
            'description' => ['required'],
            'number_of_berth' => ['required'],
            'type_of_berth' => ['required'],
            'max_draft' => ['required'],
            'max_length' => ['required'],
            'cancellation_policy' => ['required'],
            'getting_to_marina' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $book_show_status = ($request->has('book_show_status')) ? 1 : 0;
        $address = [
            'address_1' => $request->address_1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address_2' => null,
            'city' => $request->city_id,
            'state' => null,
            'zip' => $request->zip,
            'country' => $request->country,
        ];
        $user = User::find($this->user()->id);

        $updateUser = $user->update([
            'firstname' => $request->firstname,
            'city_id' => $request->city_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $address
        ]);

        $userContactPersonalDetails = MarinaDetail::where('marina_id', $this->user()->id)->first();
        if(!empty($userContactPersonalDetails)){
            $updateUserDetails = $userContactPersonalDetails->update([
                'description'           => $request->description,
                'book_show_status'      => $book_show_status,
                'number_of_berth'       => $request->number_of_berth,
                'type_of_berth'         => $request->type_of_berth,
                'max_draft'             => $request->max_draft,
                'max_length'            => $request->max_length,
                'cancellation_policy'   => $request->cancellation_policy,
                'getting_to_marina'     => $request->getting_to_marina
            ]);
        }
        else{
            $updateUserDetails = MarinaDetail::create([
                'marina_id'             => $this->user()->id,
                'description'           => $request->description,
                'book_show_status'      => $book_show_status,
                'number_of_berth'       => $request->number_of_berth,
                'type_of_berth'         => $request->type_of_berth,
                'max_draft'             => $request->max_draft,
                'max_length'            => $request->max_length,
                'cancellation_policy'   => $request->cancellation_policy,
                'getting_to_marina'     => $request->getting_to_marina
            ]);          
        }

        if ($updateUserDetails) {
            toastr()->success(lang('Marina details has been updated successfully', 'alerts'));
        }
        if ($updateUser) {
            toastr()->success(lang('Marina details has been updated successfully', 'alerts'));
        }
        return back();
    }

    /**
     * Marina amenity update 
     **/
    public function marinasFeaturedAmenitiesUpdate(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        $status = $request->status;
        $amenity_id = $request->amenity_id;
        $existRecord = MarinaAmenity::where(['marina_id' => $marinaId, 'amenity_id' => $amenity_id])->first();
        $msg = lang('Amenity status update successfully', 'alerts');
        if(!empty($existRecord)){
            $amenityData = $existRecord->update([
                                'featured_status' => $status
                            ]);
        }
        else{
            $amenityData = MarinaAmenity::create([
                                'marina_id' => $marinaId,
                                'amenity_id' => $amenity_id,
                                'featured_status' => $status
                            ]);
        }
        return json_encode($msg);
    }

    public function marinasBerthSpaces(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        if($marinaId){
            $user = User::find(userAuthInfo()->id);
            $cityList = City::where('status', 1)->get();
            return view('frontend.user.marinas.berthSpaces', ['user' => $user, 'cityList' => $cityList]);
        }
        else{
            toastr()->error(__('Access denied'));
            return back();
        }
    }

    public function marinasAmenities(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        if($marinaId){
            $selectedAmenity = [];
            $user = User::find(userAuthInfo()->id);
            $amenities = Amenity::where('status', 1)->paginate(15);
            $selectedAmenityList = MarinaAmenity::where('marina_id', $marinaId)->pluck('amenity_id');
            foreach($selectedAmenityList as $rrr){
                array_push($selectedAmenity, $rrr);
            }
            return view('frontend.user.marinas.amenities', ['user' => $user, 'amenities' => $amenities, 'selectedAmenity' => $selectedAmenity]);
        }
        else{
            toastr()->error(__('Access denied'));
            return back();
        }
    }

    /**
     * Marina amenity update 
     **/
    public function marinasAmenitiesUpdate(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        $status = $request->status;
        $amenity_id = $request->amenity_id;
        $existRecord = MarinaAmenity::where(['marina_id' => $marinaId, 'amenity_id' => $amenity_id])->count();
        if($existRecord > 0){
            $msg = lang('Amenity remove successfully', 'alerts');
            MarinaAmenity::where(['marina_id' => $marinaId, 'amenity_id' => $amenity_id])->delete();
        }
        else{
            $msg = lang('Amenity added successfully', 'alerts');
            $amenityData = MarinaAmenity::create([
                                'marina_id' => $marinaId,
                                'amenity_id' => $amenity_id
                            ]);
        }
        return json_encode($msg);
    }

    public function marinasPhotos(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        if($marinaId){
            $user = User::find(userAuthInfo()->id);
            $photosList = MarinaPhotos::where('marina_id', $marinaId)->orderbyDesc('id')->paginate(15);
            return view('frontend.user.marinas.photos', ['user' => $user, 'photosList' => $photosList]);
        }
        else{
            toastr()->error(__('Access denied'));
            return back();
        }
    }

    /**
     * @Function: Marinas Photos Add 
     **/
    public function marinasPhotosAdd(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        if($marinaId){
            $user = User::find(userAuthInfo()->id);
            return view('frontend.user.marinas.photo-add', ['user' => $user]);
        }
        else{
            toastr()->error(__('Access denied'));
            return back();
        }
    }

    /**
     *@Function: Photo add 
     **/
    public function photosAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($request->has('image')) {
            $image = vImageUpload($request->file('image'), 'images/marina-photo/', '110x110');
        } else {
            $image = "images/avatars/default.png";
        }

        $affectedRow = MarinaPhotos::create([
            'marina_id'  => userAuthInfo()->id,
            'image'      => $image
        ]); 

        if ($affectedRow) {
            toastr()->success(lang('Photo added successfully', 'alerts'));
        }
        return redirect()->route('user.marinasPhotos');
    }

    /**
     * @Function: Marinas Photos Add 
     **/
    public function marinasPhotosDelete($id)
    {
        $marinaPhoto = MarinaPhotos::find($id);
        if(!empty($marinaPhoto)){
            removeFile($marinaPhoto->image);
            MarinaPhotos::where('id', $id)->delete();
            toastr()->success(lang('Photo remove successfully', 'alerts'));
        }
        else{
            toastr()->error(__('Record not found!'));
        }
        return back();
    }

    /**
     * Function@  Login logs
     **/
    public function loginLogs(Request $request)
    {
        $marinaId = userAuthInfo()->id;
        if($marinaId){
            $user = User::find(userAuthInfo()->id);
            $logs = UserLog::where('user_id', $marinaId)->orderbyDesc('id')->paginate(12);
            return view('frontend.user.marinas.login-logs', ['user' => $user, 'logs' => $logs, 'marinaDetail' => $user]);
        }
        else{
            toastr()->error(__('Access denied'));
            return back();
        }
    }
}

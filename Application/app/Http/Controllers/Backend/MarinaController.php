<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\City;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Marina;
use App\Models\UserLog;
use App\Models\Category;
use App\Models\Amenity;
use App\Models\MarinaPhotos;
use App\Models\MarinaAmenity;
use App\Models\MarinaDetail;
use App\Models\UserContactPersonal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class MarinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        $unreadUsers = Marina::where(['read_status' => 0, 'role' => 1])->get();
        if (count($unreadUsers) > 0) {
            foreach ($unreadUsers as $unreadUser) {
                $unreadUser->read_status = 1;
                $unreadUser->save();
            }
        }
        $activeUsersCount = Marina::where(['status' => 1, 'role' => 1])->get()->count();
        $bannedUserscount = Marina::where(['status' => 0, 'role' => 1])->get()->count();
        if ($request->input('search')) {
            $q = $request->input('search');
            $users = Marina::where('firstname', 'like', '%' . $q . '%')
                ->OrWhere('lastname', 'like', '%' . $q . '%')
                ->OrWhere('email', 'like', '%' . $q . '%')
                ->OrWhere('mobile', 'like', '%' . $q . '%')
                ->OrWhere('role', 1)
                ->orderbyDesc('id')
                ->with('subscription')
                ->get();
        } elseif ($request->input('filter')) {
            $filter = $request->input('filter');
            $arr = ['active', 'banned'];
            abort_if(!in_array($filter, $arr), 404);
            $status = ($filter == 'active') ? 1 : 0;
            $users = Marina::where('status', $status)->where('role', 1)->orderbyDesc('id')->with('subscription')->get();
        } else {
            $users = Marina::where('role', 1)->orderbyDesc('id')->with('subscription')->paginate(12);
        }
        return view('backend.marinas.index', [
            'users' => $users,
            'activeUsersCount' => $activeUsersCount,
            'bannedUserscount' => $bannedUserscount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $password = Str::random(16);
        $cityList = City::where('status', 1)->get();
        return view('backend.marinas.create', ['password' => $password, 'cityList' => $cityList]);
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
            'firstname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'string', 'max:100', 'unique:users'],
            'country' => ['required'],
            'city_id' => ['required'],
            'mobile' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        /*$findCountry = Country::find($request->country);*/
        $findCountry = Country::find(110);
        if ($findCountry == null) {
            toastr()->error(__('Country not found'));
            return back()->withInput();
        }

        $findMobileCode = Country::find($request->mobile_code);
        if ($findMobileCode == null) {
            toastr()->error(__('Phone code error'));
            return back()->withInput();
        }

        if (!settings('mail_status')) {
            toastr()->error(__('SMTP is not enabled'));
            return back()->withInput();
        }

        if ($request->has('avatar')) {
            $avatar = vImageUpload($request->file('avatar'), 'images/avatars/users/', '110x110');
        } else {
            $avatar = "images/avatars/default.png";
        }

        $phoneNumber = $findMobileCode->phone . $request->mobile;

        $existMobile = Marina::where('mobile', $phoneNumber)->first();
        if ($existMobile) {
            toastr()->error(__('Phone number already exist'));
            return back()->withInput();
        }

        $address = ['address_1' => '', 'address_2' => '', 'city' => '', 'state' => '', 'zip' => '', 'country' => $findCountry->name];

        $createUser = Marina::create([
            'firstname' => $request->firstname,
            'email' => $request->email,
            'city_id' => $request->city_id,
            'mobile' => $phoneNumber,
            'address' => $address,
            'avatar' => $avatar,
            'role' => 1,
            'password' => Hash::make($request->password),
            'bc_id' => md5($request->password),
            'read_status' => 1,
        ]);

        if ($createUser) {

            $sub = 'Registration successfully';
            $emailData['email'] = $request->email;
            $emailData['password'] = $request->password;
            $emailData['user_name'] = ucfirst($request->firstname);
            $html= view('mail.registration_successfully',$emailData);

            $this->sendEmail($request->email, $sub, $html);

            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.marinas.edit', $createUser->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Marina $user)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Marina $marina)
    {
        $userSpend = Transaction::where([['user_id', $marina->id], ['status', 2]])->sum('total_price');
        $subscription = Subscription::where('user_id', $marina->id)->with('plan')->first();
        $userTransfers = Transfer::where('user_id', $marina->id)->count();
        $cityList = City::where('status', 1)->get();
        $plans = Plan::all();
        return view('backend.marinas.edit.index', [
            'marina' => $marina,
            'userSpend' => $userSpend,
            'subscription' => $subscription,
            'userTransfers' => $userTransfers,
            'cityList' => $cityList,
            'plans' => $plans,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function marinaProfile($id)
    {
        $marina = Marina::findOrFail($id);
        $marinaDetail = MarinaDetail::where('marina_id', $id)->first();
        $userSpend = Transaction::where([['user_id', $id], ['status', 2]])->sum('total_price');
        $subscription = Subscription::where('user_id', $id)->with('plan')->first();
        $userTransfers = Transfer::where('user_id', $id)->count();
        $amenityID = array('15', '16', '17', '18');
        $amenities = Amenity::whereIn('id', $amenityID)->get();
        $cityList = City::where('status', 1)->get();
        $selectedAmenityList = MarinaAmenity::where(['marina_id' => $id, 'featured_status' => 1])->pluck('amenity_id');
        $featuredAmenity = [];
        foreach($selectedAmenityList as $rrr){
            array_push($featuredAmenity, $rrr);
        }
        $active_tab = 'details';
        return view('backend.marinas.marina-profile', [
            'marina' => $marina,
            'user' => $marina,
            'userSpend' => $userSpend,
            'subscription' => $subscription,
            'userTransfers' => $userTransfers,
            'cityList' => $cityList,
            'amenities' => $amenities,
            'featuredAmenity' => $featuredAmenity,
            'active_tab' => $active_tab,
            'amenities' => $amenities,
            'marinaDetail' => $marinaDetail,
        ]);
    }

    public function berthSpaces($id)
    {
        $marina = Marina::findOrFail($id);
        $userSpend = Transaction::where([['user_id', $id], ['status', 2]])->sum('total_price');
        $subscription = Subscription::where('user_id', $id)->with('plan')->first();
        $userTransfers = Transfer::where('user_id', $id)->count();
        $plans = Plan::all();
        $active_tab = 'berth-spaces';
        return view('backend.marinas.berth-spaces', [
            'marina' => $marina,
            'userSpend' => $userSpend,
            'subscription' => $subscription,
            'userTransfers' => $userTransfers,
            'plans' => $plans,
            'active_tab' => $active_tab,
        ]);
    }

    public function amenities($id)
    {
        $selectedAmenity = [];
        $marina = Marina::findOrFail($id);
        $userSpend = Transaction::where([['user_id', $id], ['status', 2]])->sum('total_price');
        $subscription = Subscription::where('user_id', $id)->with('plan')->first();
        $userTransfers = Transfer::where('user_id', $id)->count();
        $amenities = Amenity::where('status', 1)->paginate(15);
        $selectedAmenityList = MarinaAmenity::where('marina_id', $id)->pluck('amenity_id');
        foreach($selectedAmenityList as $rrr){
            array_push($selectedAmenity, $rrr);
        }
        $plans = Plan::all();
        $active_tab = 'amenities';
        return view('backend.marinas.marina-amenities', [
            'marina' => $marina,
            'userSpend' => $userSpend,
            'subscription' => $subscription,
            'userTransfers' => $userTransfers,
            'plans' => $plans,
            'active_tab' => $active_tab,
            'amenities' => $amenities,
            'selectedAmenity' => $selectedAmenity,
        ]);
    }

    public function marinaPhotos($id)
    {
        $marina = Marina::findOrFail($id);
        $photosList = MarinaPhotos::where('marina_id', $id)->orderbyDesc('id')->paginate(15);
        $plans = Plan::all();
        $active_tab = 'photos';
        return view('backend.marinas.marina-photos', [
            'marina' => $marina,
            'photosList' => $photosList,
            'active_tab' => $active_tab,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marina $marina)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:50'],
            'city_id' => ['required'],
            'email' => ['required', 'email', 'string', 'max:100', 'unique:users,email,' . $marina->id],
            'mobile' => ['required', 'string', 'max:50', 'unique:users,mobile,' . $marina->id],
            'address_1' => ['max:255'],
            'address_2' => ['max:255'],
            'city' => ['max:150'],
            'state' => ['max:150'],
            'zip' => ['max:100'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        /*$findCountry = Country::find($request->country);*/
        $findCountry = Country::find(110);
        if ($findCountry == null) {
            toastr()->error(__('Country not found'));
            return back();
        }

        $datetime = Carbon::now();
        $status = ($request->has('status')) ? 1 : 0;
        $google2fa_status = ($request->has('google2fa_status')) ? 1 : 0;

        $address = [
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $findCountry->name,
        ];

        $update = $marina->update([
            'firstname' => $request->firstname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'city_id' => $request->city_id,
            'address' => $address,
            'google2fa_status' => $google2fa_status,
            'status' => $status,
        ]);

        if ($update) {
            $emailValue = ($request->has('email_status')) ? $datetime : null;
            $marina->forceFill([
                'email_verified_at' => $emailValue,
            ])->save();
            toastr()->success(__('Updated Successfully'));
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marina $marina)
    {/*
        if (!is_null($marina->subscription)) {
            toastr()->error(__('User has a subscription, delete the subscription to be able to delete the user'));
            return back();
        }
        if (count($marina->supportTickets) > 0) {
            toastr()->error(__('User has support tickets, delete the tickets to be able to delete the user'));
            return back();
        }*/
        if ($marina->avatar != "images/avatars/default.png") {
            removeFile($marina->avatar);
        }
        $marina->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }

    /**
     * @Function: Marinas Photos Add 
     **/
    public function marinasPhotosRemove($id)
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
     * Update user avatar
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id = user id
     * @return \Illuminate\Http\Response
     */
    public function changeAvatar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error]);
            }
        }
        $marina = User::find($id);
        if ($marina == null) {
            return response()->json(['error' => __('User not found')]);
        }
        if ($request->has('avatar')) {
            if ($marina->avatar == 'images/avatars/default.png') {
                $uploadAvatar = vImageUpload($request->file('avatar'), 'images/avatars/users/', '110x110');
            } else {
                $uploadAvatar = vImageUpload($request->file('avatar'), 'images/avatars/users/', '110x110', null, $marina->avatar);
            }
        } else {
            return response()->json(['error' => __('Upload error')]);
        }
        $update = $marina->update([
            'avatar' => $uploadAvatar,
        ]);
        if ($update) {
            return response()->json(['success' => __('Updated Successfully')]);
        }
    }

    /**
     * delete user avatar
     *
     * @param  $id = user id
     * @return \Illuminate\Http\Response
     */
    public function deleteAvatar($id)
    {
        $user = Marina::findOrFail($id);
        $avatar = "images/avatars/default.png";
        if ($user->avatar != $avatar) {
            removeFile($user->avatar);
        } else {
            toastr()->error(__('Default avatar cannot be deleted'));
            return back();
        }
        $update = $user->update([
            'avatar' => $avatar,
        ]);
        if ($update) {
            toastr()->success(__('Removed Successfully'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id = User id
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string'],
            'reply_to' => ['required', 'email'],
            'message' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!settings('mail_status')) {
            toastr()->error(__('SMTP is not enabled'));
            return back()->withInput();
        }

        $user = Marina::find($id);
        if ($user == null) {
            toastr()->error(__('User not found'));
            return back();
        }

        try {
            $email = $user->email;
            $subject = $request->subject;
            $replyTo = $request->reply_to;
            $msg = $request->message;
            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $replyTo) {
                $message->to($email)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->html($msg);
            });
            toastr()->success(__('Sent successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error(__('Sent error'));
            return back();
        }
    }

    /**
     * View logs page
     *
     * @param  $id = User id
     * @return \Illuminate\Http\Response
     */
    public function logs($id)
    {
        $marina = Marina::findOrFail($id);
        $logs = UserLog::where('user_id', $marina->id)->select('id', 'ip', 'location')->orderbyDesc('id')->paginate(6);
        return view('backend.marinas.edit.logs', ['marina' => $marina, 'logs' => $logs]);
    }

    /**
     * View bookings page
     *
     * @param  $id = User id
     * @return \Illuminate\Http\Response
     */
    public function bookings($id)
    {
        $marina = User::findOrFail($id);
        $bookings = array();
        return view('backend.marinas.edit.bookings', ['marina' => $marina, 'bookings' => $bookings]);
    }

    /**
     * Sent ajax requet to get log
     *
     * @param  $id = user id
     *  @param  $log_id = log id
     * @return \Illuminate\Http\Response as json
     */
    public function getLogs($id, $log_id)
    {
        $log = UserLog::where([['user_id', $id], ['id', $log_id]])->first();
        if ($log != null) {
            $log['ip_link'] = route('admin.marinas.logsbyip', $log->ip);
            return response()->json($log);
        } else {
            return response()->json(['error' => __('Log not found')]);
        }
    }

    /**
     * View logs by ip
     *
     * @param  $ip = log ip
     * @return \Illuminate\Http\Response
     */
    public function logsByIp($ip)
    {
        $logs = UserLog::where('ip', $ip)->with('user')->paginate(12);
        return view('backend.marinas.logs', ['logs' => $logs]);
    }

    /**
     * View logs by ip
     *
     * @param  $ip = log ip
     * @return \Illuminate\Http\Response
     */
    public function requestList()
    {
        $requestList = User::where('request_status', '>', 0)->orderbyDesc('id')->paginate(20);
        return view('backend.marinas.request-list', ['requestList' => $requestList]);
    }

    /**
     * Get user information on select change
     *
     * @return \Illuminate\Http\Response
     */
    public function appoveMarina(Request $request)
    {
        $request_id = $request->id;
        $statusid = $request->statusid;
        $status = 0;
        if($request_id)
        {
            $password = rand(100000000, 999999999);
            $marinaDetails = Marina::where('id', $request_id)->first();
            if($statusid == 2){
                $affectedRow = Marina::where('id', $request_id)->update(['email_verified_at' => date('Y-m-d H:i:s'), 'role' => 1, 'request_status' => $statusid, 'password' => Hash::make($password), 'bc_id' => md5($password)]);
                if($affectedRow){

                    $plan = Plan::where('id', unhashid('V53YMO'))->first();
                    $checkoutId = sha1(Str::random(40));
                    $tax_price = ($plan->price * countryTax($marinaDetails->address->country ?? vIpInfo()->country)) / 100;
                    $total_price = ($plan->price + $tax_price);
                    $type = 0;
                    $detailsBeforeDiscount = [
                        'plan_price' => priceFormt($plan->price),
                        'tax_price' => priceFormt($tax_price),
                        'total_price' => priceFormt($total_price),
                    ];
                    $createTrabsaction = Transaction::create([
                        'checkout_id' => $checkoutId,
                        'transaction_id' => randomCode(16),
                        'user_id' => $marinaDetails->id,
                        'plan_id' => $plan->id,
                        'details_before_discount' => $detailsBeforeDiscount,
                        'plan_price' => $plan->price,
                        'tax_price' => $tax_price,
                        'total_price' => $total_price,
                        'status' => 2,
                        'type' => $type,
                    ]);

                    $createSubscription = Subscription::create([
                        'user_id' => $marinaDetails->id,
                        'plan_id' => $plan->id,
                        'expiry_at' => '2024-12-30 12:28:12',
                    ]);

                    $status = 1;

                    $sub = 'Registration successfully';
                    $emailData['email'] = $marinaDetails->email;
                    $emailData['password'] = $password;
                    $emailData['user_name'] = ucfirst($marinaDetails->firstname);
                    $html= view('mail.registration_successfully',$emailData);

                    $this->sendEmail($marinaDetails->email, $sub, $html);
                }
            }
            else{
                $affectedRow = Marina::where('id', $request_id)->update(['request_status' => $statusid]);
                if($affectedRow){
                    $status = 1;

                    $sub = 'Request rejected';
                    $emailData['msg'] = 'You Request Is Rejected By Admin';
                    $emailData['user_name'] = ucfirst($marinaDetails->firstname);
                    $html= view('mail.common-temp',$emailData);

                    $this->sendEmail($marinaDetails->email, $sub, $html);
                }
            }
        }
        return response()->json([
            'status' => $status,
        ]);
    }

    /**
     *@Function: send email 
     **/
    public function sendEmail($email,$subject,$message)
    {   
        $params = array(

            'to'        => $email,   

            'subject'   => $subject,

            'html'      => $message,

            'from'      => 'support@html.manageprojects.in',
            
            'fromname'  => 'Framesport'

        );

        $request =  'https://api.sendgrid.com/api/mail.send.json';

        $headr = array();

        $pass = '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';

        $headr[] = 'Authorization: Bearer '.$pass;
    
        $session = curl_init($request);

        curl_setopt ($session, CURLOPT_POST, true);

        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

        curl_setopt($session, CURLOPT_HEADER, false);

        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // add authorization header

        curl_setopt($session, CURLOPT_HTTPHEADER,$headr);

        $response = curl_exec($session);

        curl_close($session);

        return true;
    }
}

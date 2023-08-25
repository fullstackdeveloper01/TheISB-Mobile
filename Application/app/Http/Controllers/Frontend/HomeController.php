<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Methods\ReCaptchaValidation;
use App\Models\Country;
use App\Models\Settings;
use App\Models\SocialProvider;
use App\Models\User;
use App\Models\UserLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.login');
        //return view('frontend.home');
        if(userAuthInfo()){
            return redirect()->route('user.dashboard');
        }
        else{
            return view('frontend.request-form');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:50'],
            'country' => ['required', 'numeric', 'same:mobile_code'],
            'mobile_code' => ['required', 'numeric', 'same:country'],
            'mobile' => ['required', 'numeric', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
        ] + ReCaptchaValidation::validate());
    }

    public function requestForm(Request $request)
    {
        $this->validator($request->all())->validate();

        $findCountry = Country::find($request->country);
        if ($findCountry == null) {
            toastr()->error(lang('Country not exists', 'alerts'));
            return back()->withInput();
        }

        $findMobileCode = Country::find($request->mobile_code);
        if ($findMobileCode == null) {
            toastr()->error(lang('Phone code not exsits', 'alerts'));
            return back()->withInput();
        }

        $mobile = $findMobileCode->phone . $request->mobile;

        $existMobile = User::where('mobile', $mobile)->first();
        if ($existMobile) {
            toastr()->error(lang('Phone number already exist', 'alerts'));
            return back()->withInput();
        }

        $data = array_merge($request->all(), [
            'phone_number' => $mobile,
            'country_name' => $findCountry->name,
        ]);

        $user = $this->create($data);
        if($user){
            toastr()->success(lang('Request submitted successfully!', 'alerts'));
            return back();
        }
        else{
            toastr()->error(lang('Oops! request is not submitted successfully!', 'alerts'));
            return back()->withInput();
        }

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $password = rand(10000, 99999);
        $address = ['address_1' => '', 'address_2' => '', 'city' => '', 'state' => '', 'zip' => '', 'country' => $data['country_name']];
        $avatar = "images/avatars/default.png";
        $createUser = User::create([
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'mobile' => $data['phone_number'],
            'address' => $address,
            'avatar' => $avatar,
            'role' => 4,
            'request_status' => 1,
            'password' => Hash::make($password),
            'bc_id' => md5($password),
        ]);
        if ($createUser) {
            $sub = 'Request submitted';
            $emailData['msg'] = "Welcome to Framesport! We're so excited to have you as part of our team. We're glad you've chosen us.";
            $emailData['user_name'] = ucfirst($createUser->firstname);
            $html= view('mail.common-temp',$emailData);

            $this->sendEmail($createUser->email, $sub, $html);
            $this->createLog($createUser);
        }
        return $createUser;
    }

    /**
     * Create a new log
     *
     * @return // save data
     */
    public function createLog($user)
    {
        $log = new UserLog();
        $log->user_id = $user->id;
        $log->ip = vIpInfo()->ip;
        $log->country = vIpInfo()->country;
        $log->country_code = vIpInfo()->country_code;
        $log->timezone = vIpInfo()->timezone;
        $log->location = vIpInfo()->location;
        $log->latitude = vIpInfo()->latitude;
        $log->longitude = vIpInfo()->longitude;
        $log->browser = vBrowser();
        $log->os = vPlatform();
        $log->save();
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

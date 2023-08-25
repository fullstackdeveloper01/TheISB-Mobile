<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class OperatorsController extends Controller
{
	protected function user()
    {
        $user = User::find(userAuthInfo()->id);
        $user['name'] = $user->firstname . ' ' . $user->lastname;
        return $user;
    }
	
    public function index()
    {
        if(userAuthInfo()->role > 1){
            toastr()->error(__('Access denied, try again!'));
            return redirect()->route('user.dashboard');
        }
		$operatersList = User::where('role', 2)->orderbyDesc('id')->paginate(20);
        return view('frontend.user.operators.index', ['operatersList' => $operatersList]);
    }

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.user.operators.create', []);
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
            'lastname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'string', 'max:100', 'unique:users'],
            'mobile' => ['required', 'numeric', 'unique:users'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
		$password = rand(10000, 99999);
        $createOperator = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'avatar' => "images/avatars/default.png",
            'role' => 2,
            'password' => Hash::make($password),
            'bc_id' => md5($password)
        ]);
        $name_ = $request->firstname.' '.$request->lastname;

        if ($createOperator) {
            $sub = 'Registration successfully';
            $emailData['email'] = $request->email;
            $emailData['password'] = $password;
            $emailData['user_name'] = ucfirst($name_);
            $html= view('mail.operator_registration',$emailData);

            $this->sendEmail($request->email, $sub, $html);

            toastr()->success(__('Created Successfully'));
            return redirect()->route('user.operators');
        }
        toastr()->error(__('Records not saved properly, try again!'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $operator)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $id)
    {
        return view('frontend.user.operators.edit', [
            'user' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $operator)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'mobile' => ['required', 'numeric', 'unique:users,mobile,' . $request->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $update = User::where('id', $request->id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'mobile' => $request->mobile,
            'status' => $request->status
        ]);

        if ($update) {
            toastr()->success(__('Updated Successfully'));
        }
        return redirect()->route('user.operators');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $operator)
    {
        $operator->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
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

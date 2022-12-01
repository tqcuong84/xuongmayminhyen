<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;

use App\Events\UserLastLogin;
use App\Models\User;

class UserController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin.home';

    protected function authenticated() {

        $user = Auth::user();

        event(new UserLastLogin($user));
    }

    protected function redirectTo()
    {
        return route($this->redirectTo);
    }

    public function login(Request $request)
    {
        if ($this->guard()->user()) {
            return redirect()->route('admin.home');
        }

        return view('admin.login');
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|email',
            'password' => 'required|string',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);
        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        $errors = new MessageBag([$this->username() => [trans('auth.failed')]]);
        return Redirect::back()->withErrors($errors);
    }

    public function logout(Request $request){
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerate();

        return redirect()->route('admin.login');
    }

    public function index(){
        $staffs = User::listStaffs(20);
        return view('admin.users', [
            "staffs" => $staffs,
        ]);
    }

    public function add(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.user-add', [
            'result' => $result
        ]);
    }

    public function postAdd(Request $request){
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')
                        ->where('email', $request->email)->where('deleted', 0)
                ],
                'password' => 'required|confirmed|min:6'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->is_staff = 1;
        $user->role_id = User::USER_MOD_ROLE;
        $user->save();


        return view('admin.user-add', [
            'result' => 'success'
        ]);
    }

    public function view(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.users');
        }
        $staff = User::find($id);
        if(!(isset($staff->id) && $staff->id)){
            return redirect()->route('admin.users');
        }
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.user-view',[
            'result' => $result,
            'staff' => $staff
        ]);
    }

    public function postUpdate(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.users');
        }
        $user = User::find($id);
        if(!(isset($user->id) && $user->id)){
            return redirect()->route('admin.users');
        }
        if(!$user->is_staff){
            return redirect()->route('admin.users');
        }
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'email' => [
                    'required',
                    'email',
                    'unique:users'. ',id,' . $id
                ],
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }
        if(!empty($request->password) && $request->password != $request->password_confirmation){
            return redirect()->back()
                ->withErrors((new MessageBag(['Nhập lại mật khẩu không đúng']))->first())
                ->withInput($request->input());
        }
        
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();


        return view('admin.user-view', [
            'result' => 'success',
            'staff' => $user
        ]);
    }
}

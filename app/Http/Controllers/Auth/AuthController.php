<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * The Socialite instance.
     *
     * @var Laravel\Socialite\Contracts\Factory
     */
    protected $socialite;

    /**
     * The scopes we request from Facebook.
     *
     * @var array
     */
    protected $scopes = ['email'];

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $socialite)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->socialite = $socialite;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Return a redirect to Facebook.
     *
     * @return mixed
     */
    public function getFacebookSocialAuth()
    {
        return $this->socialite->with('facebook')->scopes($this->scopes)->redirect();
    }

    /**
     * Return a redirect to Facebook re-requesting all scopes.
     *
     * @return mixed
     */
    public function getFacebookReSocialAuth()
    {
        return $this->socialite->with('facebook')->scopes($this->scopes)->with(['auth_type' => 'rerequest'])->redirect();
    }

    /**
     * Process the Facebook callback, ensure they gave us the correct permissions, create the user if they don't exist, and log them in.
     *
     * @return mixed
     */
    public function getSocialAuthCallback()
    {
        $user = $this->socialite->with('facebook')->user();

        if (!$this->validateUserFacebookAttributes($user)) {
            return $this->getFacebookReSocialAuth();
        }

        if (User::where('facebook_id', $user->id)->get()->count() === 0) {
            $dbUser = $this->createUserFromSocialite($user);
        } else {
            $dbUser = User::where('facebook_id', $user->id)->get()->first();
        }

        Auth::loginUsingId($dbUser->id);

        return redirect('/');
    }

    protected function validateUserFacebookAttributes($user)
    {
        return $user->email != null && $user->user['verified'] !== null;
    }

    protected function createUserFromSocialite($user)
    {
        return User::create([
            'name'        => $user->name,
            'email'       => $user->email,
            'token'       => $user->token,
            'facebook_id' => $user->id,
            'verified'    => $user->user['verified'],
        ]);
    }
}

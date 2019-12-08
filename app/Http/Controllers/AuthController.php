<?php 

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Response;
use DB;
use Auth;
use Carbon\Carbon;
use App\User;
use Hash;
use Socialite;
use Illuminate\Support\Str;
use View;
use App\Banned;
use App\Email;
use App\Category;
use App\Service;
use App\Exchange_g2f;

class AuthController  extends Controller
{
    private $request;

    public function __construct(Request $request) {
        
        //$this->middleware('auth');
        $this->request = $request;
    }  
    
    public function postchangePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

    }
    
    
    
 public function postprofile()
    {
 
       $user = User::find((Auth::user()->id));
       
       
            $user->address1 =    $this->request['address1'];
              $user->address2 =  $this->request['address2'];
                $user->state =  $this->request['state'];
                  $user->country =  $this->request['country'];
                    $user->mobile = $this->request['mobile'];
                    
                          
            $user->save();
     $view = View::make('system.profile',  compact([ 'user'])) ;
 

    return $view; 
    }
    
public function profile( )
    {
  $user = User::find(Auth::user()->id);
  
     $view = View::make('system.profile',  compact([ 'user'])) ;
 

    return $view; 
    }


    
    public function userInfoValidate()
    {
        $this->request->validate([
            'displayName' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        return response()->json([
            'success' => true,
        ]);
    }

    public function usernameValidate()
    {
        $this->request->validate([
            'username' => 'required|string|alpha_dash|min:4|unique:users',
        ]);
        return response()->json([
            'success' => true,
        ]);
    }
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup()
    {
        if(config('settings.authorization_method') == 0) {
            $this->request->validate([
                'username' => 'required|string|alpha_dash|min:4|unique:users',
            ]);
        }

        $this->request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'displayName' => 'nullable|string|max:50',
        ]);

        $verifyCoder = Str::random(32);

        $user = new User([
            'name' => $this->request->displayName ? $this->request->displayName : $this->request->username,
            'username' => $this->request->username ? $this->request->username : null,
            'email' => $this->request->email,
            'password' => bcrypt($this->request->password),
            'email_verified_code' => $verifyCoder
        ]);
        $user->save();

        /** Send activation email if registration method is advanced */
        if(config('settings.registration_method') == 1) {

            (new Email)->verifyAccount($user, $validationLink = route('frontend.auth.user.verify', ['code' => $verifyCoder]));

            return response()->json([
                'activation' => true,
                'email' => 'sent'
            ]);
        }

        if(config('settings.user_notif_welcome') == 1) {
            (new Email)->newUser($user);
        }

        /** If registration method is simplified then login the user right away  */
        $login = [
            'username' => $this->request->username,
            'password' => $this->request->password,
        ];

        if(Auth::attempt($login, true))
        {
            /** send welcome email */
            (new Email)->newUser(Auth::user());


            if( $this->request->is('api*') )
            {
                $user = $this->request->user();
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($this->request->remember_me)
                    $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                return response()->json([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ]);
            } else {
                return $this->request->user();
            }
        }
    }

    /**
     * Check if banned and get user IP
     */

    private function userBannedCheck(){
        if(Auth::user()->banned) {
            $banned = Banned::findOrFail(Auth::user()->id);



            if(Carbon::now()->timestamp >= Carbon::parse($banned->end_at)->timestamp){
                User::where('id', Auth::user()->id)
                    ->update(['banned' => 0]);
                Banned::destroy($banned->user_id);
            } else {
                abort('403', 'You are banned from this server. Reason: ' . $banned->reason . '. Date the ban will be lifted: ' . Carbon::parse($banned->end_at)->format('H:i F j Y') . '.');
            }

        } else {
            $user = User::find((Auth::user()->id));
            $user->logged_ip = request()->ip();
            $user->save();
        }
    }
    
    
       /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login()
    {
        if(config('settings.authorization_method') == 0) {
          
            $this->request->validate([
                'username' => 'required|string|alpha_dash',
                'password' => 'required|string',
            ]);

            $credentials = [
                'username' => $this->request->username,
                'password' => $this->request->password,
            ];
            
            
        } else {
            
            $this->request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $credentials = [
                'email' => $this->request->email,
                'password' => $this->request->password,
            ];
        }

        if(!Auth::attempt($credentials, true))
        {
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => array('message' => array('Unauthorized.'))
            ], 401);
        }
        
        

        $this->userBannedCheck();

        if( $this->request->is('api*') )
        {
            $user = $this->request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(30);
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        }
        
        

        return $this->request->user();
        
        
    }


 public function systemlogin(Request $request)
    {
        
        /* 
            $this->request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
*/ 
            $credentials = [
                'email' => $this->request->email,
                   'password' => $this->request->password
            ];
       
      
        
        
         
     
         $captcha = $request->input('g-recaptcha-response');
        
        
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lf4bL0UAAAAAMsM9mBy1Yzq6Fzzu3EXereHEM4l&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
    
     
        $responseKeys = json_decode($response,true);
        
         
        // should return JSON with success as true
        if($responseKeys["success"]) {
         
             
            
            $data = Exchange_g2f::where('email',  '=' ,$this->request->email)->get();
            
              
             if(count($data)==1)
             
             { 
                 
                // echo "check g2f auth";
               //  var_dump($credentials); 
     $view = View::make('system.g2f',  ['data' => $credentials]   )  ;
 

     return $view;   
                 
             }
             
             else
             {
             
            
              
              
               if(!Auth::attempt($credentials, true))
        {
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => array('message' => array('Unauthorized.'))
            ], 401);
        }
        
   
        
         else
         {


            return redirect('/home');
             
         }    
                 
                 
        
        
        }
        
        } else {
              echo '<h2>You are spammer ! Get it out</h2>';
        }
   
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function systemlogin2(Request $request)
    { 
  //print_r($_REQUEST);      
        
       /*  
        $this->request->validate([
                'email' => 'required|string|alpha_dash',
                'password' => 'required|string',
            ]);

*/
            $credentials = [
                'email' => $this->request->email,
                   'password' => $this->request->password
            ];
       


   
            
            $data = Exchange_g2f::where('email',  '=' ,$this->request->email)->get();
     
     
     $ga=new GoogleAuthCtrl( $this->request);
     
$checkResult = $ga->verifyCode(  $data[0]->secret , $this->request->authcode  ,   2);    
 


if ($checkResult) {
    
    
  
          
               if(!Auth::attempt($credentials, true))
        {
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => array('message' => array('Unauthorized.'))
            ], 401);
        }
        
   
        
         else
         {

            return redirect('/home');
        
         } 
        
       
}

else
{
    
    echo " Auth code incorrect";
} 


    }
    
    
    

    private function createdToken($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(30);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function googleLogin()
    {
        $this->request->validate([
            'access_token' => 'required|string',
        ]);

        $googleUser = Socialite::driver('google')->userFromToken($this->request->input('access_token'));

        $googleId = $googleUser->id;
        $googleName = $googleUser->name;
        $googleEmail = $googleUser->email;

        //if google email same with email register in our database then login
        if($googleEmail)
        {
            $authUser = User::where('email', $googleEmail)->first();

            if($authUser)
            {
                if( $this->request->is('api*') )
                {
                    return $this->createdToken($authUser);
                }

                Auth::loginUsingId($authUser->id);

                $this->userBannedCheck();

                return Response::json(array(
                    'success' => true
                ), 200);

            }
        }

        //If user sign by google before, login right away
        $authUser = User::where('provider_id', $googleId)->where('provider', 'google')->first();

        if ($authUser) {

            if ($this->request->is('api*')) {
                return $this->createdToken($authUser);
            } else {
                Auth::loginUsingId($authUser->id);
                return Response::json(array(
                    'success' => true
                ), 200);
            }

        }

        //Create new account if not exits
        $artworkId = generateUuid( $googleId . time());

        DB::table('artworks')->insert(
            ['artworkId' => $artworkId, 'artworkUrl' => $googleUser->avatar]
        );

        $user = User::create([
            'name' => $googleName,
            'username' => 'fb' . $googleId,
            'password' => bcrypt($googleId . time()),
            'email' => $googleEmail ? $googleEmail : NULL,
            'provider_id' => $googleId,
            'provider' => 'google',
            'artworkId' => $artworkId
        ]);

        if( $this->request->is('api*') )
        {
            return $this->createdToken($user);
        }

        Auth::loginUsingId($user->id);

        return Response::json(array(
            'success' => true
        ), 200);
    }

    public function facebookLogin()
    {
        $this->request->validate([
            'accessToken' => 'required|string',
        ]);


        $facebookUser = Socialite::driver('facebook')->userFromToken($this->request->input('accessToken'));

        $facebookId = $facebookUser->id;
        $facebookName = $facebookUser->name;
        $facebookEmail = $facebookUser->email;

        //if facebook email same with email register in our database then login
        if($facebookEmail)
        {
            $authUser = User::where('email', $facebookEmail)->first();

            if($authUser)
            {
                if( $this->request->is('api*') )
                {
                    return $this->createdToken($authUser);
                }

                Auth::loginUsingId($authUser->id);

                $this->userBannedCheck();

                return Response::json(array(
                    'success' => true
                ), 200);

            }
        }

        //If user sign by facebook before, login right away
        $authUser = User::where('provider_id', $facebookId)->where('provider', 'facebook')->first();

        if ($authUser) {

            if ($this->request->is('api*')) {
                return $this->createdToken($authUser);
            } else {
                Auth::loginUsingId($authUser->id);
                return Response::json(array(
                    'success' => true
                ), 200);
            }

        }

        //Create new account if not exits
        $artworkId = generateUuid( $facebookId . time());

        DB::table('artworks')->insert(
            ['artworkId' => $artworkId, 'artworkUrl' => 'http://graph.facebook.com/' . $facebookId . '/picture?type=large']
        );

        $user = User::create([
            'name' => $facebookName,
            'username' => 'fb' . $facebookId,
            'password' => bcrypt($facebookId . time()),
            'email' => $facebookEmail ? $facebookEmail : NULL,
            'provider_id' => $facebookId,
            'provider' => 'facebook',
            'artworkId' => $artworkId
        ]);

        if( $this->request->is('api*') )
        {
            return $this->createdToken($user);
        }

        Auth::loginUsingId($user->id);

        return Response::json(array(
            'success' => true
        ), 200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout()
    {
        Auth::logout();

        if ($this->request->ajax() || $this->request->is('api*')) {
            return Response::json(array(
                'success' => true,
                'message' => 'Successfully logged out.'
            ), 200);

        }

        return redirect()->route('frontend.homepage');
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user()
    {
        $user = $this->request->user();
        $user->artwork = getUserArtwork($user->id);

        if ($this->request->is('api*')) {
            return response()->json($this->request->user());

        }

        /**
         * Check and send user back to default group if there is time limit
         */

        $row = DB::table('role_users')->select('ends_at')->where('user_id', $user->id)->first();

        if(isset($row->ends_at) && $row->ends_at != '0000-00-00 00:00:00' && (Carbon::now()->timestamp > Carbon::parse($row->ends_at)->timestamp)) {
            (new User)->setRole($user->id, config('settings.default_usergroup'));
        }

        return response()->json($user);
    }

    public function forgotPassword()
    {
        $this->request->validate([
            'email' => 'string|email|exists:users',
        ]);

        $user = User::where('email',  $this->request->input('email'))->firstOrFail();

        $row = DB::table("password_resets")->select('email')->where('email', $user->email)->first();
        $token = Str::random(60);

        if(isset($row->email))
        {
            DB::table("password_resets")->where('email', $user->email)->update([
                'token' => $token,
                'created_at' => Carbon::now()

            ]);
        } else {
            DB::table("password_resets")->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        (new Email)->resetPassword($user, route('frontend.auth.reset-password', ['token' => $token]));

        return response()->json([
            'message' =>  trans('auth.forgotSent')
        ]);
    }

    public function resetPassword()
    {
        $row = DB::table("password_resets")->select('email')->where('token', $this->request->route('token'))->first();

        if(isset($row->email))
        {
            $user = User::where('email',  $row->email)->firstOrFail();
            /** Log user in then show the change password form */
            Auth::login($user);
            return view('reset-password');
        } else {
            return redirect()->route('frontend.homepage')->with('status', 'failed')->with('message', trans('Your reset code is invalid or has expired.'));
        }
    }

    public function resetPasswordPost()
    {
        if(! Auth::check())
        {
            abort('403');
        }

        $this->request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        /**
         * Change user password
         */
        $user = Auth::user();
        $user->password = bcrypt($this->request->input('password'));
        $user->save();

        /**
         * Delete password reset token
         */
        DB::table("password_resets")->where('email', $user->email)->delete();

        return redirect()->route('frontend.homepage')->with('status', 'success')->with('message', trans('auth.resetPasswordSuccess'));
    }

    public function addArticle()
    {
        /** get allowed categories */
        $allowCategories = Category::findMany(Auth::user()->getRoleValue('post_allow_categories'));

        $view = View::make('profile.add-article')->with('allowCategories', $allowCategories);
        return $view;
    }

    public function addArticlePost(){
        $this->request->validate([
            'title' => 'required|string|max:250',
            'allow_main' => 'nullable|boolean',
            'fixed' => 'nullable|boolean',
            'category' => 'required|array',
            'short_content' => 'required|string',
        ]);

        $post = new Post();

        $post->title = $this->request->input('title');
        $post->alt_name = $this->request->input('alt_name');

        if( ! $post->alt_name ) {
            $post->alt_name = str_slug($post->title);
        } else {
            $post->alt_name = str_slug($post->alt_name);
        }

        $post->category = $this->request->input('category');
        $post->category = implode(",", $this->request->input('category'));

        $post->tags = $this->request->input('tags');
        if(is_array($post->tags))
        {
            $post->tags = implode(",", $this->request->input('tags'));

        }

        if(Auth::user()->hasAccess(['post_main'])) {
            $post->allow_main = intval($this->request->input('allow_main'));
        }

        if(Auth::user()->hasAccess(['post_pin'])) {
            $post->fixed = intval($this->request->input('fixed'));
        }

        if(Auth::user()->hasAccess(['post_mod'])) {
            /** If user is allowed to publish news without verification, and the category use selected are in trusted section, set approve = 1 */
            //First get trusted section (an array or category) from role
            $trustedSection = Auth::user()->getRoleValue('post_trusted_categories');
            //Compare both array
            if(array_intersect($this->request->input('category'), $trustedSection)) {
                $post->approve = 1;
            }
        }

        $post->short_content = $this->request->input('short_content');
        $post->full_content = $this->request->input('full_content');
        $post->user_id = Auth::user()->id;
        $post->save();

        return redirect()->route('frontend.homepage')->with('status', 'success')->with('message', 'Article successfully created!');
    }

    public function membership()
    {

        $services = Service::all();

        $view = View::make('membership.index')->with('services', $services);

        if ($this->request->ajax()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }

        getMetatags();

        return $view;
    }
    
    
    
   
    protected $_codeLength = 6;

    /**
     * Create new secret.
     * 16 characters, randomly chosen from the allowed base32 characters.
     *
     * @param int $secretLength
     * @return string
     */
    public function createSecret($secretLength = 16)
    {
        $validChars = $this->_getBase32LookupTable();
        unset($validChars[32]);

        $secret = '';
        for ($i = 0; $i < $secretLength; $i++) {
            $secret .= $validChars[array_rand($validChars)];
        }
        return $secret;
    }

    /**
     * Calculate the code, with given secret and point in time
     *
     * @param string $secret
     * @param int|null $timeSlice
     * @return string
     */
    public function getCode($secret, $timeSlice = null)
    {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }

        $secretkey = $this->_base32Decode($secret);

        // Pack time into binary string
        $time = chr(0).chr(0).chr(0).chr(0).pack('N*', $timeSlice);
        // Hash it with users secret key
        $hm = hash_hmac('SHA1', $time, $secretkey, true);
        // Use last nipple of result as index/offset
        $offset = ord(substr($hm, -1)) & 0x0F;
        // grab 4 bytes of the result
        $hashpart = substr($hm, $offset, 4);

        // Unpak binary value
        $value = unpack('N', $hashpart);
        $value = $value[1];
        // Only 32 bits
        $value = $value & 0x7FFFFFFF;

        $modulo = pow(10, $this->_codeLength);
        return str_pad($value % $modulo, $this->_codeLength, '0', STR_PAD_LEFT);
    }

    /**
     * Get QR-Code URL for image, from google charts
     *
     * @param string $name
     * @param string $secret
     * @param string $title
     * @return string
     */
    public function getQRCodeGoogleUrl($name, $secret, $title = null) {
        $urlencoded = urlencode('otpauth://totp/'.$name.'?secret='.$secret.'');
	if(isset($title)) {
                $urlencoded .= urlencode('&issuer='.urlencode($title));
        }
        return 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl='.$urlencoded.'';
    }

    /**
     * Check if the code is correct. This will accept codes starting from $discrepancy*30sec ago to $discrepancy*30sec from now
     *
     * @param string $secret
     * @param string $code
     * @param int $discrepancy This is the allowed time drift in 30 second units (8 means 4 minutes before or after)
     * @param int|null $currentTimeSlice time slice if we want use other that time()
     * @return bool
     */
    public function verifyCode($secret, $code, $discrepancy = 1, $currentTimeSlice = null)
    {
        if ($currentTimeSlice === null) {
            $currentTimeSlice = floor(time() / 30);
        }

        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $calculatedCode = $this->getCode($secret, $currentTimeSlice + $i);
            if ($calculatedCode == $code ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set the code length, should be >=6
     *
     * @param int $length
     * @return GoogleAuthenticator
     */
    public function setCodeLength($length)
    {
        $this->_codeLength = $length;
        return $this;
    }

    /**
     * Helper class to decode base32
     *
     * @param $secret
     * @return bool|string
     */
    protected function _base32Decode($secret)
    {
        if (empty($secret)) return '';

        $base32chars = $this->_getBase32LookupTable();
        $base32charsFlipped = array_flip($base32chars);

        $paddingCharCount = substr_count($secret, $base32chars[32]);
        $allowedValues = array(6, 4, 3, 1, 0);
        if (!in_array($paddingCharCount, $allowedValues)) return false;
        for ($i = 0; $i < 4; $i++){
            if ($paddingCharCount == $allowedValues[$i] &&
                substr($secret, -($allowedValues[$i])) != str_repeat($base32chars[32], $allowedValues[$i])) return false;
        }
        $secret = str_replace('=','', $secret);
        $secret = str_split($secret);
        $binaryString = "";
        for ($i = 0; $i < count($secret); $i = $i+8) {
            $x = "";
            if (!in_array($secret[$i], $base32chars)) return false;
            for ($j = 0; $j < 8; $j++) {
                $x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); $z++) {
                $binaryString .= ( ($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48 ) ? $y:"";
            }
        }
        return $binaryString;
    }

    /**
     * Helper class to encode base32
     *
     * @param string $secret
     * @param bool $padding
     * @return string
     */
    protected function _base32Encode($secret, $padding = true)
    {
        if (empty($secret)) return '';

        $base32chars = $this->_getBase32LookupTable();

        $secret = str_split($secret);
        $binaryString = "";
        for ($i = 0; $i < count($secret); $i++) {
            $binaryString .= str_pad(base_convert(ord($secret[$i]), 10, 2), 8, '0', STR_PAD_LEFT);
        }
        $fiveBitBinaryArray = str_split($binaryString, 5);
        $base32 = "";
        $i = 0;
        while ($i < count($fiveBitBinaryArray)) {
            $base32 .= $base32chars[base_convert(str_pad($fiveBitBinaryArray[$i], 5, '0'), 2, 10)];
            $i++;
        }
        if ($padding && ($x = strlen($binaryString) % 40) != 0) {
            if ($x == 8) $base32 .= str_repeat($base32chars[32], 6);
            elseif ($x == 16) $base32 .= str_repeat($base32chars[32], 4);
            elseif ($x == 24) $base32 .= str_repeat($base32chars[32], 3);
            elseif ($x == 32) $base32 .= $base32chars[32];
        }
        return $base32;
    }

    /**
     * Get array with all 32 characters for decoding from/encoding to base32
     *
     * @return array
     */
    protected function _getBase32LookupTable()
    {
        return array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
            'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
            '='  // padding char
        );
    }
 
}
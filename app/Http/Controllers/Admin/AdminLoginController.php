<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
class AdminController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('auth:admin');

    }

    /**

     * show dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        return view('admin');

    }

}

?>
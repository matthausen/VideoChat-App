<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Pusher\Pusher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function authenticate(Request $request) {
        $socketId =  $request->socket_id;
        $channelName = $request->channel_name;

        $pusher = new Pusher('cc15caa1b51c06c5138b', 'fd4cf1610404f5510ee1', '713230', [
            'cluster' => 'eu',
            'encrypted' => true
        ]);

        $presence_data = ['name' =>auth()->user()->name];
        $key = $pusher->presence_auth($channelName, $socketId, auth()->id(), $presence_data);

        return response($key);
    }
}

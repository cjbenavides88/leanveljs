<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $url = 'https://polaris6365.leankit.com/io/card';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('master');
    }

    public function test(){
        $client = new Client();
        $result = $client->request('GET',$this->url,[
            'auth' => ['carlos.benavides@polaris.com','pkmnmaster06'],
            'headers' => [
                'User-Agent' => 'application/json',
                'Accept'     => 'application/json',
            ],
            'query' => [
                'board' => 487537051,
                'limit' => 5000,
            ],
        ]);

        return $result;
    }
}

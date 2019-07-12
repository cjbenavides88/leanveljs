<?php


namespace App\Http\Helpers;


use GuzzleHttp\Client;

class LeanKitHelper
{
    private $client;            //Guzzle Client
    private $options = [];      //Guzzle Request Options

    public function __construct(string $account, array $auth = [])
    {
        // Create a client with a base URI
        $client = new Client(['base_uri' => 'https://' . $account . '.leankit.com/io/']);


        // TODO Bring Auth Info when logged in. Else use parameter.
        // Auth
        $this->options['auth'] = $auth;

        // Default Headers
        $this->options['headers'] = [
            'User-Agent' => 'application/json',
            'Accept'     => 'application/json',
        ];
    }

    public function apiCall(string $method, string $url, array $query = []){
        $result = $this->client->request($method,$url,$query );
        return $result;
    }

    /**
     * Return all the account boards.
     * docs/board/board:list
     *
     * @param array $query Leankit board:list parameters
     */
    // TODO add all LeanKit API Options
    public function getBoards(array $query = []){
        self::apiCall('GET','board',  $query);
    }
}
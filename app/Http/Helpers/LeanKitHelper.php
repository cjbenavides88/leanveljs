<?php


namespace App\Http\Helpers;


use GuzzleHttp\Client;

class LeanKitHelper
{
    private $client;            //Guzzle Client
    private $options = [];      //Guzzle Request Options

    public function __construct(string $account, string $user, string $password)
    {
        // Create a client with a base URI
        $client = new Client(['base_uri' => 'https://' . $account . '.leankit.com/io/']);

        // Auth
        $this->options['auth'] = [$user,$pasword];

        // Default Headers
        $this->options['headers'] = [
            'User-Agent' => 'application/json',
            'Accept'     => 'application/json',
        ];
    }

    public function apiCall(string $method, string $url, array $query = []){
        $result = $this->client->request($method,$url,$query);
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
        return self::apiCall('GET','board',$query);
    }
    
    /**
     * Return the board information of the requested id.
     * docs/board/board:self
     * 
     * @param int $id ID of the Board to get
     * @param array $query Leankit board:self parameters
     */
    public function getBoard(int $id, array $query = []){
        $query['board'] = $id;
        return self::apiCall('POST','board',$query);
    }
}

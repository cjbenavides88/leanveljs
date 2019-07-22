<?php


namespace App\Http\Helpers\Leankit;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class LeanKitHelper
{
    private $client;            //Guzzle Client
    private $options = [];      //Guzzle Request Options

    public function __construct(string $account, string $user, string $password)
    {
        // Create a client with a base URI
        $this->client = new Client(['base_uri' => 'https://' . $account . '.leankit.com/io/']);

        // Auth
        $this->options['auth'] = [$user,$password];

        // Default Headers
        $this->options['headers'] = [
            'User-Agent' => 'application/json',
            'Accept'     => 'application/json',
        ];
    }

    private function apiCall(string $method, string $url, array $query = []){
        $this->options['query'] = $query;
        try{
            $result = $this->client->request($method,$url,$this->options);
            return $result;
        }catch ( ClientException $clientException){
            return $clientException->getResponse();
        }
    }

    /**
     * Return information of the account.
     * /docs/account/account:self
     *
     * @return string JSON Response from Leankit
     */
    public function getAccountInfo(){
        return self::apiCall('GET','account');
    }

    /**
     * Return all the account boards.
     * docs/board/board:list
     *
     * @param array $query Leankit board:list parameters
     * @return string
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
     * @return string
     */
    public function getBoard(int $id, array $query = []){
        $query['board'] = $id;
        return self::apiCall('POST','board',$query);
    }

    /**
     * Return list of users of the account.
     * /docs/user
     *
     * @return string JSON Response from Leankit
     */
    public function getUserList(){
        return self::apiCall('GET','user');
    }

    /**
     * Return information of the current user.
     * /docs/account/account:me
     *
     * @return string JSON Response from Leankit
     */
    public function getCurrentUser(){
        return self::apiCall('GET','user/me');
    }



}

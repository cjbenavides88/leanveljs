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

    public function apiCall(string $method, string $url, array $query = []){
        $this->options['query'] = $query;
        try{
            $result = $this->client->request($method,$url,$this->options);
            return $result;
        }catch ( ClientException $clientException){
            return $clientException->getResponse();
        }
    }

/*
|------------------------------------------------------------------------------------------------------------------
| Account API Calls
|------------------------------------------------------------------------------------------------------------------
| account:self  => getAccountInfo
| account:me    => getAccountInfo
|------------------------------------------------------------------------------------------------------------------
*/
    /**
     * Return information of the account.
     * /docs/account/account:self
     *
     * @return string JSON Response from Leankit
     */
    public function getAccountInfo(){
        return self::apiCall('GET','account');
    }
/*
 |------------------------------------------------------------------------------------------------------------------
 | Auth API Calls
 |------------------------------------------------------------------------------------------------------------------
 | auth:listTokens  => PENDING
 | auth:createToken => PENDING
 | auth:revokeToken => PENDING
 |------------------------------------------------------------------------------------------------------------------
 */
    /**
     * TODO AUTH API CALLS
     */
/*
|------------------------------------------------------------------------------------------------------------------
| Board API Calls
|------------------------------------------------------------------------------------------------------------------
| board:list        => getBoards
| board:create      => PENDING
| board:self        => getBoard
| board:delete      => PENDING
| board:archive     => PENDING
| board:unarchive   => PENDING
| customField:self  => PENDING
| customField:update=> PENDING
|------------------------------------------------------------------------------------------------------------------
*/
    /**
     * Return all the account boards.
     * docs/board/board:list
     *
     * @param array $query Leankit board:list parameters
     * @return string
     */
    public function getBoards(array $query = []){
        return self::apiCall('GET','board',$query);
    }
    
    /**
     * Return the board information of the requested id.
     * docs/board/board:self
     * 
     * @param int $boardID ID of the Board to get
     * @param array $query Leankit board:self parameters
     * @return string
     */
    public function getBoard(int $boardID, array $query = []){
        return self::apiCall('GET','board/' . $boardID ,$query);
    }
/*
|------------------------------------------------------------------------------------------------------------------
| Card API Calls
|------------------------------------------------------------------------------------------------------------------
| attachment:list       => PENDING
| attachment:create     => PENDING
| attachment:update     => PENDING
| attachment:delete     => PENDING
| attachment:content    => PENDING
| card:list             => PENDING
| card:create           => PENDING
| card:self             => PENDING
| card:update           => PENDING
| card:delete           => PENDING
| comment:list          => PENDING
| comment:create        => PENDING
| comment:update        => PENDING
| comment:delete        => PENDING
| comment:list          => PENDING
|------------------------------------------------------------------------------------------------------------------
*/
    /**
     * Returns a list of Card resources. Cards are returned in descending
     * order by 'updatedOn' date-time value (most recently modified cards first).
     * docs/card/card:list
     *
     * @param array $query Leankit card:list parameters
     * @return string
     */
    public function getCards(array $query = []){
        return self::apiCall('GET','card',$query);
    }
/*
|------------------------------------------------------------------------------------------------------------------
| Template API Calls
|------------------------------------------------------------------------------------------------------------------
| template:list       => PENDING
| template:create     => PENDING
| template:delete     => PENDING
|------------------------------------------------------------------------------------------------------------------
*/
    /**
     * TODO TEMPLATE API CALLS
     */
/*
|------------------------------------------------------------------------------------------------------------------
| User API Calls
|------------------------------------------------------------------------------------------------------------------
| user:list         => getUserList
| user:me           => getCurrentUser
| user:self         => PENDING
| userBoards:recent => PENDING
|------------------------------------------------------------------------------------------------------------------
*/
    /**
     * Return list of users of the account.
     * /docs/user/user:list
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
/*
|------------------------------------------------------------------------------------------------------------------
| OrganizationLookup API Calls
|------------------------------------------------------------------------------------------------------------------
| organizationLookup:create => PENDING
|------------------------------------------------------------------------------------------------------------------
*/
    /**
     * TODO OrganizationLookup API CALLS
     */
/*
|------------------------------------------------------------------------------------------------------------------
| Devices API Calls
|------------------------------------------------------------------------------------------------------------------
| devices:register => PENDING
|------------------------------------------------------------------------------------------------------------------
*/
    /**
     * TODO Devices API CALLS
     */
}

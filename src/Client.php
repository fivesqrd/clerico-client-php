<?php
namespace Clerico;

class Client
{
    protected $_client;

    protected $_token;

    protected $_headers = [
        'Content-Type' => 'application/json',
        'Accept'       => 'application/json'
    ];

    const DEFAULT_URI = 'https://clerico.5sq.io/api/';

    public static function instance($config = [])
    {
        $uri = isset($config['uri']) ? $config['uri'] : static::DEFAULT_URI;
        
        if (substr($uri, -1, 1) != '/') {
            /* Add trialing slash for Guzzle client quirk */
            $uri .= '/';
        }

        return new static(
            new \GuzzleHttp\Client(['base_uri' => $uri]), $config['token']
        );
    }

    public function __construct($client, $token)
    {
        $this->_client = $client;
        $this->_headers['X-Clerico-Token'] = $token;
    }

    /**
     * @todo Figure out a way to cache this for a while
     * @param string $path
     * @throws Frog_Exception
     * @return Zend_Http_Response
     */
    public function get($path, $query = array())
    {
        $response = $this->_client->request(
            'GET', $path, ['query' => $query, 'headers' => $this->_headers]
        );

        if ($response->getStatusCode() != 200) {
            throw new Exception(
                $response->getReasonPhrase() . ' response received while trying to connect to Clerico'
            );
        }

        if ($response->getHeader('Content-Type')[0] == 'application/json') {
            return json_decode(
                (string) $response->getBody()
            );
        }

        return (string) $response->getBody();
    }

    public function post($path, $data, $query = array())
    {
        $response = $this->_client->request(
            'POST', $path, ['json' => $data, 'query' => $query, 'headers' => $this->_headers]
        );

        if ($response->getStatusCode() != 200) {
            throw new Exception(
                $response->getReasonPhrase() . ' response received while trying to connect to Clerico'
            );
        }

        if ($response->getHeader('Content-Type') == 'application/pdf') {
            return (string) $response->getBody();
        }

        return json_decode(
            (string) $response->getBody()
        );
    }

    public function put($path, $data, $query = array())
    {
        $response = $this->_client->request(
            'PUT', $path, ['json' => $data, 'query' => $query, 'headers' => $this->_headers]
        );

        if ($response->getStatusCode() != 200) {
            throw new Exception(
                $response->getReasonPhrase() . ' response received while trying to connect to Clerico'
            );
        }

        return json_decode(
            (string) $response->getBody()
        );
    }

    public function delete($path, $query = array())
    {
        $response = $this->_client->request(
            'DELETE', $path, ['query' => $query, 'headers' => $this->_headers]
        );

        if ($response->getStatusCode() != 200) {
            throw new Exception(
                $response->getReasonPhrase() . ' response received while trying to connect to Clerico'
            );
        }

        return json_decode(
            (string) $response->getBody()
        );
    }
}

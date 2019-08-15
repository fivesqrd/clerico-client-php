<?php
namespace Clerico;

class Proxy
{

    protected $_client;

    protected $_variant;

    protected $_attributes = [];


    public  function __construct($client, $variant, $attributes = [])
    {
        $this->_client = $client;
        $this->_variant = $variant;
        $this->_attributes = $attributes;
    }

    public function send()
    {
        return $this->_client->post(
            "delivery/{$this->_variant}", $this->_attributes
        );
    }

    public function render()
    {
        return $this->_client->post(
            "document/{$this->_variant}", $this->_attributes
        );
    }
}
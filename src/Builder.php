<?php
namespace Clerico;

class Builder
{
    protected $_attributes = [];

    public function attribute($key, $value)
    {
        $this->_attributes[$key] = $value;

        return $this;
    }

    public function title($value)
    {
        return $this->attribute('title', $value);
    }

    public function expose()
    {
        return $this->_attributes;
    }
}
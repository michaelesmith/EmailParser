<?php

namespace MS\Email\Parser;

/**
 * @author msmith
 */
class Address
{
    protected $name;

    protected $address;

    protected $original;

    public function __construct($str)
    {
        if(strpos($str, '<') === false){
            $this->address = $str;
            $this->original = $str;
        }else{
            $matches = array();
            preg_match('/(.*)(<.*>)/', $str, $matches);
            $this->name = trim($matches[1], "\" \t\r\n\0\x0B");
            $this->address = trim($matches[2], "<> \t\r\n\0\x0B");
            $this->original = $str;
        }
    }

    public function __toString()
    {
        return trim(sprintf("%s <%s>", $this->getName(), $this->getAddress()));
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getOriginal()
    {
        return $this->original;
    }

    public function getName()
    {
        return $this->name;
    }

}

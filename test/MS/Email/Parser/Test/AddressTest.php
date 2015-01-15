<?php

namespace MS\Email\Parser\Test;

use MS\Email\Parser\Address;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class AddressTest extends TestCase
{
    public function testConstruct()
    {
        $a = new Address('Dan Occhi <dan@example.com>');
        $this->assertEquals('Dan Occhi', $a->getName());
        $this->assertEquals('dan@example.com', $a->getAddress());

        $a = new Address('"Dan Occhi" <dan@example.com>');
        $this->assertEquals('Dan Occhi', $a->getName());
        $this->assertEquals('dan@example.com', $a->getAddress());

        $a = new Address('<dan@example.com>');
        $this->assertEquals('', $a->getName());
        $this->assertEquals('dan@example.com', $a->getAddress());

        $a = new Address('dan@example.com');
        $this->assertEquals('', $a->getName());
        $this->assertEquals('dan@example.com', $a->getAddress());
    }
    
    public function testJsonSerializable()
    {
        $address = new Address('Dan Occhi <dan@example.com>');
        $expected = '{"name":"Dan Occhi","address":"dan@example.com"}';
        
        $this->assertEquals($expected, json_encode($address));
    }

}

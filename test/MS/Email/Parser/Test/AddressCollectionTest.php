<?php

namespace MS\Email\Parser\Test;

use MS\Email\Parser\AddressCollection;
use MS\Email\Parser\Address;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class AddressCollectionTest extends TestCase
{    
    public function testJsonSerializable()
    {
        // test data
        $addresses = [];
        $addresses[] = new Address('Dan Occhi <dan@example.com>');
        $addresses[] = new Address('Michael Smith <sitecross@gmail.com>');
        $addresses[] = new Address('Sébastien Monterisi <sebastienmonterisi@yahoo.fr>');
        $addressCollection = new AddressCollection($addresses);

        // expected data
        // $this->prepareExpectation($addressCollection);
        $expected = '[{"name":"Dan Occhi","address":"dan@example.com"},{"name":"Michael Smith","address":"sitecross@gmail.com"},{"name":"S\u00e9bastien Monterisi","address":"sebastienmonterisi@yahoo.fr"}]';
        
        $this->assertEquals($expected, json_encode($addressCollection));
    }

    /**
     * use only to prepare expected data, in case Address serialization changes 
     * @param AddressCollection $addresses
     */
    private function prepareExpectation(AddressCollection $addresses)
    {
        // starts with array bracket
        $expected = '[';
        foreach ($addresses as $address)
        {
            $expected .= json_encode($address).',';
        }
        // remove last ','
        $expected = substr($expected, 0, -1);
        // ends with array bracket
        $expected .= ']';
        
        var_dump($expected);
        exit(1);
    }
}

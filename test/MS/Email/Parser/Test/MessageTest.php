<?php

namespace MS\Email\Parser\Test;

use MS\Email\Parser\Parser;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class MessageTest extends TestCase
{
    
    
    public function testJsonSerializable()
    {
//        $parser = ;
        $message = (new Parser())->parse(file_get_contents(__DIR__ . '/files/thunderbird.txt'));

        // expected data
//        $this->prepareExpectation($message);
        $expected = '{"date":"Wed, 30 Jan 2013 16:18:32 -0600","to":[{"name":"","address":"atapi@astrotraker.com"}],"cc":[],"from":{"name":"Michael Smith","address":"example@textilemanagement.com"},"subject":"Fwd: test subject","html_body":"<html>\n  <head>\n\n    <meta http-equiv=\"content-type\" content=\"text\/html; charset=ISO-8859-1\">\n  <\/head>\n  <body bgcolor=\"#FFFFFF\" text=\"#000000\">\n    <br>\n      <br>\n      <pre>--\n\nThanks,\nMichael\n\n\n<\/pre>\n      <br>\n    <\/div>\n    <br>\n  <\/body>\n<\/html>","text_body":"\n\n--\n\nThanks,\nMichael\n"}';

        $this->assertEquals($expected, json_encode($message));
    }

    /**
     * use only to prepare expected data, in case Address serialization changes 
     * @param AddressCollection $addresses
     */
    private function prepareExpectation(\MS\Email\Parser\Message $message)
    {
        // starts with array bracket
        $expected_array = [];
        $expected_array['date'] = ($message->getDate());
        $expected_array['to'] = ($message->getTo());
        $expected_array['cc'] = ($message->getCC());
        $expected_array['from'] = ($message->getFrom());
        $expected_array['subject'] = ($message->getSubject());
        $expected_array['html_body'] = ($message->getHtmlBody());
        $expected_array['text_body'] = ($message->getTextBody());
        
        var_dump(json_encode($expected_array));
        exit(1);
    }
}

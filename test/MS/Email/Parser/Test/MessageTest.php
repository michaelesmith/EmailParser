<?php

namespace MS\Email\Parser\Test;

use MS\Email\Parser\Parser;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class MessageTest extends TestCase
{

    public function testgetBcc()
    {
        $raw = $this->getMailFileContents('0');
        $parsed = (new Parser())->parse($raw);
        
        // first bcc
        $this->assertEquals('someone-in-bcc@somewhere.com' , $parsed->getBcc()->first()->getAddress());
        $this->assertEmpty( $parsed->getBcc()->first()->getName());        
        
        // last bcc
        $this->assertEquals('someoneelse-in-bcc@somewhere.com' , $parsed->getBcc()->last()->getAddress());
        $this->assertEquals('justin nainconnu' , $parsed->getBcc()->last()->getName());
    }
    
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
        
    /**
     * get raw content of a mail
     * 
     * @param  string$ mail_file
     * @throws \RuntimeException
     */
    private function getMailFileContents($mail_file)
    {
        $file = __DIR__.'/files/'.$mail_file.'.txt';
        $content = file_get_contents($file);
        if(!$content) {
            throw new \RuntimeException("can not load email file [$file]");
        }
        return $content;
    }

}

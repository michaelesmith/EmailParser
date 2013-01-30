<?php

namespace MS\Email\Parser\Test;

use MS\Email\Parser\Parser;

/**
 * @author msmith
 */
class ParserTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testParse($file, $fromName, $fromAddress, $toName, $toAddress, $subject, $textBody, $htmlBody, $attachments)
    {
        $p = new Parser();

        $m = $p->parse(file_get_contents(__DIR__ . '/files/' . $file . '.txt'));

        $this->assertEquals($fromName, $m->getFrom()->getName());
        $this->assertEquals($fromAddress, $m->getFrom()->getAddress());

        $this->assertEquals($toName, $m->getTo()->getName());
        $this->assertEquals($toAddress, $m->getTo()->getAddress());

        $this->assertEquals($subject, $m->getSubject());

        $this->assertEquals($textBody, $m->getTextBody());

        $this->assertEquals($htmlBody, $m->getHtmlBody());

        $attachmentObjects = $m->getAttachments();
        $this->assertCount(count($attachments), $attachmentObjects);
        foreach($attachments as $key => $attachment){
            $this->assertEquals($attachment[0], $attachmentObjects[$key]->getFilename());
            $this->assertEquals($attachment[1], $attachmentObjects[$key]->getmimeType());
        }
    }

    public function provider()
    {
        return array(
            array(0, 'Pawel', 'pawel@test.com', '', 'dan@test.com',
                '=?UTF-8?B?emHFvMOzxYLEhyBnxJnFm2zEhSBqYcW6xYQgaSB6csOzYiBwcsOzYm4=?= =?UTF-8?B?ZSB6YWRhbmllICUldG9k?=',
                'This is just a test. I
Repeat just a test',
                '<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body
 style="font-family: tt; font-size: 10pt;" bgcolor="#FFFFFF"
text="#000000">
<div style="font-size: 10pt;font-family: tt;"><span style="font-family:
monospace;">This is just a test. I<br>Repeat just a test<br>Pawel<br></span></div>
</body>
</html>',
                array()
            ),
            array(1, 'Dan @ Test.com', 'dan@test.com', 'Daniele', 'danielet@test.com',
                'this is a test',
                'Hope it works!',
                '',
                array()
            ),
            array(2, 'Dan', 'dan@test.com', 'Daniele', 'daniele@test.com',
                '=?ISO-2022-JP?B?GyRCJDMkbCRPJUYlOSVIJEckORsoQg==?=',
                'それは作品を期待',
                'それは作品を期待<div title="signature"> </div>',
                array()
            ),
            array(3, 'Dan Occhi', 'dan@example.com', 'Inbox_danocch.it_2063@examplebox.com', 'Inbox_danocch.it_2063@examplebox.com',
                'Voice Memo',
                '


Sent from my iPad
',
                '',
                array(
                    array('example_vmr_09102012182307.3gp', 'audio/caf')
                )
            ),
            array('gmail', 'Michael Smith', 'example@gmail.com', '', 'atapi@astrotraker.com',
                'gmail test',
                'Thanks,
Michael',
                '<div dir="ltr"><br clear="all"><div>Thanks,<div>Michael</div></div>
</div>',
                array(
                    array('e0t0tY2Py0WeHXw8qANI6A2 (1).jpg', 'image/jpeg')
                )
            ),
            array('mac_outlook', 'Cary Howell', 'example@gmail.com', '', 'atapi@astrotraker.com',
                'Test subject line',
                'Test body line.

Signature follows:
---
J. Cary Howell
e. example@gmail.com
http://www.web-developer.us


',
                '<html><head></head><body style="word-wrap: break-word; -webkit-nbsp-mode: space; -webkit-line-break: after-white-space; color: rgb(0, 0, 0); font-size: 14px; font-family: Calibri, sans-serif; "><div><div><div>Test body line.</div><div><br></div><div>Signature follows:</div><div><div><div><span class="Apple-style-span" style="font-family: Courier; border-collapse: collapse; "><font class="Apple-style-span" size="2">---</font></span></div><div><span class="Apple-style-span" style="border-collapse: collapse; "><span class="Apple-style-span" style="font-family: Calibri; ">J. Cary Howell</span></span></div><span class="Apple-style-span" style="border-collapse: collapse; font-size: 12px; ">e. <a href="mailto:example@gmail.com">example@gmail.com</a>&nbsp;</span></div><div><span class="Apple-style-span" style="border-collapse: collapse; font-size: 12px; ">http://www.web-developer.us</span><div><blockquote style="margin: 0px 0px 0px 40px; border-style: none; padding: 0px; "></blockquote></div></div><div><br></div></div></div></div></body></html>',
                array()
            ),
        );
    }

}

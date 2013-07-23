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
    public function testParse($file, $fromName, $fromAddress, $toName, $toAddress, $date, $subject, $textBody, $htmlBody, $attachments)
    {
        $p = new Parser();

        $m = $p->parse(file_get_contents(__DIR__ . '/files/' . $file . '.txt'));

        $this->assertEquals($fromName, $m->getFrom()->getName());
        $this->assertEquals($fromAddress, $m->getFrom()->getAddress());

        $this->assertEquals($toName, $m->getTo()->getName());
        $this->assertEquals($toAddress, $m->getTo()->getAddress());

        $this->assertEquals($date, $m->getDate());
        $dateObj = $m->getDateAsDateTime();
        $this->assertEquals($date, $dateObj->format('D, j M Y H:i:s O'));

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
            array(0, 'Pawel', 'pawel@test.com', '', 'dan@test.com', 'Tue, 28 Aug 2012 11:40:10 +0200',
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
            array(1, 'Dan @ Test.com', 'dan@test.com', 'Daniele', 'danielet@test.com', 'Tue, 18 Sep 2012 10:41:22 +0100',
                'this is a test',
                'Hope it works!',
                '',
                array()
            ),
            array(2, 'Dan', 'dan@test.com', 'Daniele', 'daniele@test.com', 'Tue, 18 Sep 2012 11:26:11 +0100',
                '=?ISO-2022-JP?B?GyRCJDMkbCRPJUYlOSVIJEckORsoQg==?=',
                'それは作品を期待',
                'それは作品を期待<div title="signature"> </div>',
                array()
            ),
            array(3, 'Dan Occhi', 'dan@example.com', 'Inbox_danocch.it_2063@examplebox.com', 'Inbox_danocch.it_2063@examplebox.com',
                'Tue, 9 Oct 2012 18:23:09 +0100',
                'Voice Memo',
                '


Sent from my iPad
',
                '',
                array(
                    array('example_vmr_09102012182307.3gp', 'audio/caf')
                )
            ),
            array('gmail', 'Michael Smith', 'example@gmail.com', '', 'atapi@astrotraker.com', 'Wed, 30 Jan 2013 13:03:55 -0600',
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
                'Tue, 29 Jan 2013 15:54:48 -0500',
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
            array('android', 'Michael Smith', 'example@textilemanagement.com', 'atapi@astrotraker.com', 'atapi@astrotraker.com',
                'Wed, 30 Jan 2013 17:25:07 -0500',
                'Tests',
                "\r\n\r\nSent from my Verizon Wireless 4GLTE smartphone\r\n\r\n",
                "\r\n<br><br>Sent from my Verizon Wireless 4GLTE smartphone<br><br>\r\n",
                array(
                    array('earth-moon-space-sun.jpg', 'application/octet-stream')
                )
            ),
             array('thunderbird', 'Michael Smith', 'example@textilemanagement.com', '', 'atapi@astrotraker.com',
                'Wed, 30 Jan 2013 16:18:32 -0600',
                'Fwd: test subject',
                '

--

Thanks,
Michael
',
                '<html>
  <head>

    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>
  <body bgcolor="#FFFFFF" text="#000000">
    <br>
      <br>
      <pre>--

Thanks,
Michael


</pre>
      <br>
    </div>
    <br>
  </body>
</html>',
                array(
                    array('e0t0tY2Py0WeHXw8qANI6A2 (1).jpg', 'image/jpeg')
                )
            ),
//             array('ipad', 'Michael Smith', 'example@textilemanagement.com', 'atapi@astrotraker.com', 'atapi@astrotraker.com',
//                'Wed, 30 Jan 2013 17:46:37 -0500',
//                'Fwd: Tests',
//                "\r\n\r\nSent from my Verizon Wireless 4GLTE smartphone\r\n\r\n",
//                "\r\n<br><br>Sent from my Verizon Wireless 4GLTE smartphone<br><br>\r\n",
//                array(
//                    array('e0t0tY2Py0WeHXw8qANI6A2 (1).jpg', 'application/octet-stream')
//                )
//            ),
             array('ipad2', 'Cary Howell', 'example@textilemanagement.com', 'atapi@astrotraker.com', 'atapi@astrotraker.com',
                'Thu, 31 Jan 2013 16:20:45 -0500',
                'Samples P200',
                'Test',
                '',
                array(
                    array('packing_slip.png', 'image/png'),
                    array('Screen shot 2013-01-31 at 9.21.59 AM.png', 'image/png'),
                    array('tracking_number.png', 'image/png'),
                )
            ),
        );
    }

}

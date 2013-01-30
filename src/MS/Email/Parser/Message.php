<?php

namespace MS\Email\Parser;

/**
 * @author msmith
 */
class Message
{

    protected $htmlBody;

    protected $textBody;

    protected $attachments = array();

    protected $to;

    protected $from;

    protected $subject;

    public function __construct($from, $to, $subject, $textBody, $htmlBody, $attachments = array())
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->textBody = $textBody;
        $this->htmlBody = $htmlBody;
        $this->attachments = $attachments;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @return \MS\Email\Parser\Address
     */
    public function getFrom()
    {
        return $this->from;
    }

    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getTextBody()
    {
        return $this->textBody;
    }

    /**
     * @return \MS\Email\Parser\Address
     */
    public function getTo()
    {
        return $this->to;
    }

}

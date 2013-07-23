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

    protected $date;

    public function __construct($from, $to, $subject, $textBody, $htmlBody, $attachments = array(), $date)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->textBody = $textBody;
        $this->htmlBody = $htmlBody;
        $this->attachments = $attachments;
        $this->date = $date;
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

    public function getDate()
    {
        return $this->date;
    }

    public function getDateAsDateTime()
    {
        return \DateTime::createFromFormat('D, j M Y H:i:s O', $this->date);
    }

    /**
     * @return \MS\Email\Parser\Address
     */
    public function getTo()
    {
        return $this->to;
    }

}

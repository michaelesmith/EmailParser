<?php

namespace MS\Email\Parser;

use JsonSerializable;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class Message implements JsonSerializable
{

    protected $htmlBody;
    protected $textBody;
    protected $attachments = array();
    protected $to;
    protected $cc;
    protected $from;
    protected $subject;
    protected $date;
    /**
     * @var AddressCollection hidden recipients
     */
    protected $bcc;

    public function __construct(Address $from, AddressCollection $to, AddressCollection $cc, $subject, $textBody, $htmlBody, $attachments = array(), $date, AddressCollection $bcc)
    {
        $this->from = $from;
        $this->to = $to;
        $this->cc = $cc;
        $this->subject = $subject;
        $this->textBody = $textBody;
        $this->htmlBody = $htmlBody;
        $this->attachments = $attachments;
        $this->date = $date;
        $this->bcc = $bcc;
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
     * @return \MS\Email\Parser\AddressCollection
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return \MS\Email\Parser\AddressCollection
     */
    public function getCC()
    {
        return $this->cc;
    }

    /**
     * @return \MS\Email\Parser\AddressCollection
     */
    public function getBCC()
    {
        return $this->bcc;
    }

    public function jsonSerialize()
    {
        return [
            'date' => $this->getDate(),
            'to' => $this->getTo(),
            'cc' => $this->getCC(),
            'bcc' => $this->getBCC(),
            'from' => $this->getFrom(),
            'subject' => $this->getSubject(),
            'html_body' => $this->getHtmlBody(),
            'text_body' => $this->getTextBody(),
        ];
    }

}

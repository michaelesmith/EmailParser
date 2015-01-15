<?php

namespace MS\Email\Parser;

use JsonSerializable;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class Part implements JsonSerializable
{
    protected $type;

    protected $disposition;

    protected $encoding;

    protected $content;

    function __construct($content, $encoding, $type, $disposition)
    {
        $this->content = $content;
        $this->disposition = $disposition;
        $this->encoding = $encoding;
        $this->type = $type;
    }

    public function getDecodedContent()
    {
        switch(strtolower($this->encoding)){
            case '':
            case '7bit':
            case '8bit':
                $content = $this->content;
                break;
            case 'base64':
                $content = base64_decode($this->content);
                break;
            case 'quoted-printable':
                $content = quoted_printable_decode($this->content);
                break;
            default:
                throw new \RuntimeException(sprintf('unknown encoding type "%s"', $this->encoding));
        }

        return $content;
    }

    public function getEncodedContent()
    {
        return $this->content;
    }

    public function getDisposition()
    {
        return $this->disposition;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function getType()
    {
        return $this->type;
    }

    public function jsonSerialize()
    {
        return [
          'type'=>$this->getType(),
          'disposition' => $this->getDisposition(),
          'encoding' => $this->getEncoding(),
          'content' => $this->getDecodedContent()
        ];
    }

}

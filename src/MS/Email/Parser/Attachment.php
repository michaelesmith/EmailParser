<?php

namespace MS\Email\Parser;

/**
 * @author msmith
 */
class Attachment
{

    protected $filename;

    protected $content;

    protected $mimeType;

    public function __construct($filename, $content, $mimeType)
    {
        $this->filename = $filename;
        $this->content = $content;
        $this->mimeType = $mimeType;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

}

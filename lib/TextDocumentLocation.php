<?php

namespace Phpactor\TextDocument;

class TextDocumentLocation
{
    /**
     * @var TextDocument
     */
    private $document;

    /**
     * @var ByteOffset
     */
    private $offset;

    public function __construct(TextDocument $document, ByteOffset $offset)
    {
        $this->document = $document;
        $this->offset = $offset;
    }

    public function document(): TextDocument
    {
        return $this->document;
    }

    public function offset(): ByteOffset
    {
        return $this->offset;
    }
}

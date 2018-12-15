<?php

namespace Phpactor\SourceCode;

/**
 * Represents source code or other text documents.
 */
interface TextDocument
{
    /**
     * Return the document as a string
     */
    public function __toString();

    /**
     * Return the URI to the document or NULL
     */
    public function uri(): ?string;
}

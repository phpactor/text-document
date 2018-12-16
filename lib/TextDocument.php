<?php

namespace Phpactor\TextDocument;

use Phpactor\TextDocument\TextDocumentUri;

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
     * Return the URI to the document or NULL if the document has not been
     * persisted yet.
     */
    public function uri(): ?TextDocumentUri;
}

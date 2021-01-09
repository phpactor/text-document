<?php

namespace Phpactor\TextDocument;

use Phpactor\TextDocument\Exception\CouldNotSaveDocument;

/**
 * Represents a workspace to which documents can be persisted and retrieved
 */
interface Workspace
{
    /**
     * Retrieve text document by URI, returns NULL if not found
     */
    public function get(TextDocumentUri $uri): ?TextDocument;

    /**
     * Save a text document to the workspace.
     *
     * @throws CouldNotSaveDocument
     */
    public function save(TextDocument $document): void;
}

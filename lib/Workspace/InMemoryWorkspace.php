<?php

namespace Phpactor\TextDocument\Workspace;

use Phpactor\TextDocument\TextDocument;
use Phpactor\TextDocument\TextDocumentUri;
use Phpactor\TextDocument\Workspace;

final class InMemoryWorkspace implements Workspace
{
    /**
     * @var array<string, TextDocument>
     */
    private $documents = [];

    /**
     * @param array<string, TextDocument> $textDocuments
     */
    private function __construct(array $textDocuments)
    {
        $this->documents = $textDocuments;
    }

    public function get(TextDocumentUri $uri): ?TextDocument
    {
        if (isset($this->documents[$uri->__toString()])) {
            return $this->documents[$uri->__toString()];
        }

        return null;
    }

    /**
     * @param TextDocument[] $textDocuments
     */
    public static function fromTextDocuments(array $textDocuments): self
    {
        return new self((array)array_combine(array_map(function (TextDocument $document) {
            return $document->uri()->__toString();
        }, $textDocuments), array_values($textDocuments)));
    }

    public static function new(): self
    {
        return new self([]);
    }

    /**
     * {@inheritDoc}
     */
    public function save(TextDocument $document): void
    {
        $this->documents[$document->uri()->__toString()] = $document;
    }
}

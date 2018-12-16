<?php

namespace Phpactor\TextDocument;

use Phpactor\TextDocument\Exception\InvalidUriException;
use Phpactor\TextDocument\Exception\TextDocumentNotFound;
use RuntimeException;
use Webmozart\PathUtil\Path;
use Phpactor\TextDocument\TextDocumentUri;

class StandardTextDocument implements TextDocument
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var TextDocumentUri
     */
    private $uri;

    private function __construct(string $text, ?TextDocumentUri $uri = null)
    {
        $this->text = $text;
        $this->uri = $uri;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->text;
    }

    /**
     * {@inheritDoc}
     */
    public function uri(): ?TextDocumentUri
    {
        return $this->uri;
    }

    public static function create(string $text, ?string $uri = null): self
    {
        $uri = TextDocumentUri::create($uri);

        return new self($text, $uri);
    }

    public static function fromUri(string $uri)
    {
        $uri = TextDocumentUri::create($uri);

        if (!file_exists((string) $uri)) {
            throw new TextDocumentNotFound(sprintf(
                'Text Document not found at URI "%s"', $uri
            ));
        }

        if (!is_readable((string) $uri)) {
            throw new RuntimeException(sprintf(
                'Could not read file at URI "%s"', $uri
            ));
        }

        return new self(file_get_contents($uri), $uri);
    }
}

<?php

namespace Phpactor\TextDocument;

use Phpactor\TextDocument\Exception\InvalidUriException;
use Phpactor\TextDocument\Exception\TextDocumentNotFound;
use RuntimeException;
use Webmozart\PathUtil\Path;

class StandardTextDocument implements TextDocument
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $uri;

    private function __construct(string $text, ?string $uri = null)
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
    public function uri(): ?string
    {
        return $this->uri;
    }

    public static function create(string $text, ?string $uri = null): self
    {
        return new self($text, $uri);
    }

    public static function fromUri(string $uri): self
    {
        if (false === Path::isAbsolute($uri)) {
            throw new InvalidUriException(sprintf(
                'URI must be absolute, got "%s"', $uri
            ));
        }

        if (!file_exists($uri)) {
            throw new TextDocumentNotFound(sprintf(
                'Text Document not found at URI "%s"', $uri
            ));
        }

        if (!is_readable($uri)) {
            throw new RuntimeException(sprintf(
                'Could not read file at URI "%s"', $uri
            ));
        }

        return new self(file_get_contents($uri), $uri);
    }
}

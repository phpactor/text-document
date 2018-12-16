<?php

namespace Phpactor\TextDocument;

use Phpactor\TextDocument\Exception\InvalidUriException;
use Webmozart\PathUtil\Path;

class TextDocumentUri
{
    /**
     * @var string
     */
    private $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    public static function create(string $uri): self
    {
        if (false === Path::isAbsolute($uri)) {
            throw new InvalidUriException(sprintf(
                'URI must be absolute, got "%s"', $uri
            ));
        }

        return new self($uri);
    }

    public function __toString(): string
    {
        return $this->uri;
    }
}

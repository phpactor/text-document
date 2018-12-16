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

    final private function __construct()
    {
    }

    public static function create(string $uri): self
    {
        if (false === Path::isAbsolute($uri)) {
            throw new InvalidUriException(sprintf(
                'URI must be absolute, got "%s"', $uri
            ));
        }

        $new = new self();
        $new->uri = $uri;

        return $new;
    }

    public function __toString(): string
    {
        return $this->uri;
    }
}

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

    /**
     * @var TextDocumentLanguage
     */
    private $language;

    private function __construct(
        TextDocumentLanguage $language,
        string $text,
        ?TextDocumentUri $uri = null
    )
    {
        $this->text = $text;
        $this->uri = $uri;
        $this->language = $language;
    }

    public static function create(TextDocumentLanguage $language, string $text, ?TextDocumentUri $uri = null): self
    {
        return new self($language, $text, $uri);
    }

    public static function fromLanguageAndText(string $language, string $text, ?string $uri = null): self
    {
        if ($uri) {
            $uri = TextDocumentUri::create($uri);
        }

        return self::create(TextDocumentLanguage::create($language), $text, $uri);
    }

    public static function fromUri(string $uri, ?string $language = null): self
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

        if (null === $language) {
            $language = Path::getExtension((string) $uri);
        }

        return new self(
            TextDocumentLanguage::create($language),
            file_get_contents($uri),
            $uri
        );
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

    /**
     * {@inheritDoc}
     */
    public function language(): TextDocumentLanguage
    {
        return $this->language;
    }
}

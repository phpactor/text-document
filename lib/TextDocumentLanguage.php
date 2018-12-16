<?php

namespace Phpactor\TextDocument;

class TextDocumentLanguage
{
    const LANGUAGE_UNDEFINED = 'undefined';
    const LANGUAGE_PHP = 'php';

    /**
     * @var string
     */
    private $language;

    private function __construct(string $language)
    {
        $this->language = $language;
    }

    public static function create(string $language = self::LANGUAGE_UNDEFINED): self
    {
        return new self($language);
    }

    public function is(string $language)
    {
        return $this->language === strtolower($language);
    }

    public function isDefined(): bool
    {
        return !$this->is(self::LANGUAGE_UNDEFINED);
    }

    public function isPhp(): bool
    {
        return $this->is(self::LANGUAGE_PHP);
    }

    public function __toString(): string
    {
        return $this->language;
    }
}

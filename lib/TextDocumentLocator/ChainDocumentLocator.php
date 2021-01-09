<?php

namespace Phpactor\TextDocument\TextDocumentLocator;

use Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor\TextDocument\TextDocument;
use Phpactor\TextDocument\TextDocumentUri;
use Phpactor\TextDocument\TextDocumentLocator;

class ChainDocumentLocator implements TextDocumentLocator
{
    /**
     * @var TextDocumentLocator[]
     */
    private $locators;

    /**
     * @param TextDocumentLocator[] $locators
     */
    public function __construct(array $locators)
    {
        $this->locators = $locators;
    }

    /**
     * {@inheritDoc}
     */
    public function get(TextDocumentUri $uri): TextDocument
    {
        foreach ($this->locators as $workspace) {
            try {
                return $workspace->get($uri);
            } catch (TextDocumentNotFound $notFound) {
            }
        }

        throw new TextDocumentNotFound(sprintf(
            'Could not find document "%s"',
            $uri->__toString()
        ));
    }
}
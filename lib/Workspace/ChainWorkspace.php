<?php

namespace Phpactor\TextDocument\Workspace;

use Phpactor\TextDocument\TextDocument;
use Phpactor\TextDocument\TextDocumentUri;
use Phpactor\TextDocument\Workspace;

/**
 * Combine multiple workspace.
 *
 * The behavior is slightly different for the two methods:
 *
 * - `get`: Return the document from the first workspace that has it.
 * - `save`: Save the document in ALL workspaces.
 */
class ChainWorkspace implements Workspace
{
    /**
     * @var Workspace[]
     */
    private $workspaces;

    /**
     * @param Workspace[] $workspaces
     */
    public function __construct(array $workspaces)
    {
        $this->workspaces = $workspaces;
    }

    /**
     * {@inheritDoc}
     */
    public function get(TextDocumentUri $uri): ?TextDocument
    {
        foreach ($this->workspaces as $workspace) {
            $document = $workspace->get($uri);
            if (null === $document) {
                continue;
            }

            return $document;
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function save(TextDocument $document): void
    {
        foreach ($this->workspaces as $workspace) {
            $workspace->save($document);
        }
    }
}

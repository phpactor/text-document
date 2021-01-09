<?php

namespace Phpactor\TextDocument\Tests\Unit\Workspace;

use PHPUnit\Framework\TestCase;
use Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor\TextDocument\TextDocumentUri;
use Phpactor\TextDocument\Workspace;
use Phpactor\TextDocument\Workspace\ChainWorkspace;
use Phpactor\TextDocument\Workspace\InMemoryWorkspace;

class ChainWorkspaceTest extends TestCase
{
    public function testGetReturnsNullIfNoWorkspaces(): void
    {
        self::assertNull(
            $this->createWorkspace()->get(
                TextDocumentUri::fromString('file:///foobar')
            )
        );
    }

    public function testReturnsTextDocument(): void
    {
        $document = TextDocumentBuilder::create('foobar')->uri('/path/to/foo')->build();

        self::assertSame(
            $document,
            $this->createWorkspace([
                InMemoryWorkspace::fromTextDocuments([
                    $document
                ])
            ])->get(TextDocumentUri::fromString('file:///path/to/foo'))
        );
    }

    public function testReturnsTextDocumentFromFirstWorkspace(): void
    {
        $document1 = TextDocumentBuilder::create('one')->uri('/path/to/foo')->build();
        $document2 = TextDocumentBuilder::create('two')->uri('/path/to/foo')->build();

        self::assertSame(
            $document1,
            $this->createWorkspace([
                InMemoryWorkspace::fromTextDocuments([
                    $document1
                ]),
                InMemoryWorkspace::fromTextDocuments([
                    $document2
                ])
            ])->get(TextDocumentUri::fromString('file:///path/to/foo'))
        );
    }

    public function testSavesNonExistingDocumentToAllWorkspaces(): void
    {
        $document1 = TextDocumentBuilder::create('one')->uri('/path/to/foo')->build();

        $workspace1 = InMemoryWorkspace::new();
        $workspace2 = InMemoryWorkspace::new();

        $chain = $this->createWorkspace([
            $workspace1,
            $workspace2,
        ]);

        $chain->save($document1);
        self::assertSame($document1, $workspace1->get($document1->uri()));
        self::assertSame($document1, $workspace2->get($document1->uri()));
    }

    /**
     * @param Workspace[] $workspaces
     */
    private function createWorkspace(array $workspaces = []): ChainWorkspace
    {
        return new ChainWorkspace($workspaces);
    }
}

<?php

declare(strict_types=1);

namespace Rector\Website\Tests\Documentation;

use Rector\Website\Documentation\DocumentationMenuFactory;
use Rector\Website\GetRectorKernel;
use Rector\Website\ValueObject\DocumentationSection;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;

final class DocumentationMenuFactoryTest extends AbstractKernelTestCase
{
    private DocumentationMenuFactory $documentationMenuFactory;

    protected function setUp(): void
    {
        $this->bootKernel(GetRectorKernel::class);
        $this->documentationMenuFactory = $this->getService(DocumentationMenuFactory::class);
    }

    public function testSectionTitle(): void
    {
        $sectionTitle = $this->documentationMenuFactory->createSectionTitle('run-in-cI');
        $this->assertSame('Run in CI', $sectionTitle);
    }

    public function testCreate(): void
    {
        $documentationSections = $this->documentationMenuFactory->create();
        $this->assertContainsOnlyInstancesOf(DocumentationSection::class, $documentationSections);
        $this->assertGreaterThan(8, count($documentationSections));
    }
}

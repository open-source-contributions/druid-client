<?php
declare(strict_types=1);

namespace tests\Level23\Druid\Extractions;

use tests\TestCase;
use Level23\Druid\Extractions\RegexExtraction;
use Level23\Druid\Extractions\CascadeExtraction;
use Level23\Druid\Extractions\SubstringExtraction;
use Level23\Druid\Extractions\SearchQueryExtraction;

class CascadeExtractionTest extends TestCase
{
    public function testCascade()
    {
        $substr = new SubstringExtraction(12, 2);
        $regex  = new RegexExtraction('aa');
        $search = new SearchQueryExtraction('john');

        $extraction = new CascadeExtraction($substr, $regex);
        $extraction->addExtraction($search);

        $this->assertEquals([
            'type'          => 'cascade',
            'extractionFns' => [
                $substr->toArray(),
                $regex->toArray(),
                $search->toArray(),
            ],
        ], $extraction->toArray());
    }
}
<?php
declare(strict_types=1);

namespace tests\Level23\Druid\Filters;

use Level23\Druid\ExtractionFunctions\LookupExtractionFunction;
use Level23\Druid\Filters\JavascriptFilter;
use tests\TestCase;

class JavascriptFilterTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param bool $useExtractionFunction
     */
    public function testFilter(bool $useExtractionFunction)
    {
        $extractionFunction = new LookupExtractionFunction(
            'singup_by_member', false
        );

        $function = "function(x) { return(x >= 'bar' && x <= 'foo') }";

        $expected = [
            'type'      => 'javascript',
            'dimension' => 'name',
            'function'  => $function,
        ];

        if ($useExtractionFunction) {
            $filter                   = new JavascriptFilter('name', $function, $extractionFunction);
            $expected['extractionFn'] = $extractionFunction->getExtractionFunction();
        } else {
            $filter = new JavascriptFilter('name', $function);
        }

        $this->assertEquals($expected, $filter->getFilter());
    }
}
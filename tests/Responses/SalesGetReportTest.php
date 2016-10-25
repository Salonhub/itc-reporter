<?php
namespace Snscripts\ITCReporter\Tests\Responses;

use Snscripts\ITCReporter\Responses\SalesGetReport;

class SalesGetReportTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->response = $this->getMock('Psr\Http\Message\ResponseInterface');
        $this->response->method('getBody')
            ->willReturn(
                new TestSalesReportContent
            );
    }

    public function testProcessReturnsReportInArrayFormat()
    {
        $Processor = new SalesGetReport(
            $this->response
        );

        $this->assertSame(
            [
                [
                    'Header 1' => 'Foo',
                    'Header 2' => 'Bar',
                    'Header 3' => 'Foobar'
                ],
                [
                    'Header 1' => 'Fizz',
                    'Header 2' => '',
                    'Header 3' => 'Fizzbuzz'
                ],
                [
                    'Header 1' => '',
                    'Header 2' => 'Test',
                    'Header 3' => 'Tester'
                ]
            ],
            $Processor->process()
        );
    }
}

class TestSalesReportContent
{
    public function getContents()
    {
        $report = "Header 1\tHeader 2\tHeader 3\nFoo\tBar\tFoobar\nFizz\t\tFizzbuzz\n\tTest\tTester";
        return gzencode($report);
    }
}

<?php

namespace Blomstra\Spam\Tests;

use Blomstra\Spam\Filter;

class FilterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Filter::$acceptableDomains = [];
    }

    /**
     * @test
     * @covers \Blomstra\Spam\Filter::allowLinksFromDomain
     */
    function allows_full_uri()
    {
        (new Filter)
            ->allowLinksFromDomain('https://google.com/clark-kent');

        $this->assertEquals(
            'google.com',
            Filter::getAcceptableDomains()[0]
        );
    }

    /**
     * @test
     * @covers \Blomstra\Spam\Filter::allowLinksFromDomains
     */
    function allows_multiple_domains()
    {
        (new Filter)
            ->allowLinksFromDomains([
                'google.com',
                'flarum.org'
            ]);

        $this->assertEquals(
            'flarum.org',
            Filter::getAcceptableDomains()[1]
        );
    }

    /**
     * @test
     * @covers \Blomstra\Spam\Filter
     */
    function allows_fqdn()
    {
        (new Filter)
            ->allowLinksFromDomain('google.com');

        $this->assertEquals(
            'google.com',
            Filter::getAcceptableDomains()[0]
        );
    }

    /**
     * @test
     * @covers \Blomstra\Spam\Filter
     */
    function allows_ftp()
    {
        (new Filter)
            ->allowLinksFromDomain('ftp://google.com');

        $this->assertEquals(
            'google.com',
            Filter::getAcceptableDomains()[0]
        );
    }

    /**
     * @test
     * @covers \Blomstra\Spam\Filter
     */
    function allows_ip()
    {
        (new Filter)
            ->allowLinksFromDomain('127.0.0.1');

        $this->assertEquals(
            '127.0.0.1',
            Filter::getAcceptableDomains()[0]
        );
    }
}

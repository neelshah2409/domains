<?php
/**
 * Utopia PHP Framework
 *
 *
 * @link https://github.com/utopia-php/framework
 *
 * @author Eldad Fux <eldad@appwrite.io>
 *
 * @version 1.0 RC4
 *
 * @license The MIT License (MIT) <http://www.opensource.org/licenses/mit-license.php>
 */

namespace Utopia\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Utopia\Domains\Domain;

class DomainTest extends TestCase
{
    public function testEdgecaseDomains(): void
    {
        $domain = new Domain('httpmydomain.com');
        $this->assertEquals('httpmydomain.com', $domain->getRegisterable());
    }

    public function testEdgecaseDomainsError(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage("'http://httpmydomain.com' must be a valid domain or hostname");
        $domain = new Domain('http://httpmydomain.com');
    }

    public function testEdgecaseDomainsError2(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage("'https://httpmydomain.com' must be a valid domain or hostname");
        $domain = new Domain('https://httpmydomain.com');
    }

    public function testExampleCoUk(): void
    {
        $domain = new Domain('demo.example.co.uk');

        $this->assertEquals('demo.example.co.uk', $domain->get());
        $this->assertEquals('uk', $domain->getTLD());
        $this->assertEquals('co.uk', $domain->getSuffix());
        $this->assertEquals('example.co.uk', $domain->getRegisterable());
        $this->assertEquals('example', $domain->getName());
        $this->assertEquals('demo', $domain->getSub());
        $this->assertEquals(true, $domain->isKnown());
        $this->assertEquals(true, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(false, $domain->isTest());
    }

    public function testSubSubExampleCoUk(): void
    {
        $domain = new Domain('subsub.demo.example.co.uk');

        $this->assertEquals('subsub.demo.example.co.uk', $domain->get());
        $this->assertEquals('uk', $domain->getTLD());
        $this->assertEquals('co.uk', $domain->getSuffix());
        $this->assertEquals('example.co.uk', $domain->getRegisterable());
        $this->assertEquals('example', $domain->getName());
        $this->assertEquals('subsub.demo', $domain->getSub());
        $this->assertEquals(true, $domain->isKnown());
        $this->assertEquals(true, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(false, $domain->isTest());
    }

    public function testLocalhost(): void
    {
        $domain = new Domain('localhost');

        $this->assertEquals('localhost', $domain->get());
        $this->assertEquals('localhost', $domain->getTLD());
        $this->assertEquals('', $domain->getSuffix());
        $this->assertEquals('', $domain->getRegisterable());
        $this->assertEquals('', $domain->getName());
        $this->assertEquals('', $domain->getSub());
        $this->assertEquals(false, $domain->isKnown());
        $this->assertEquals(false, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(true, $domain->isTest());
    }

    public function testDemoLocalhost(): void
    {
        $domain = new Domain('demo.localhost');

        $this->assertEquals('demo.localhost', $domain->get());
        $this->assertEquals('localhost', $domain->getTLD());
        $this->assertEquals('', $domain->getSuffix());
        $this->assertEquals('', $domain->getRegisterable());
        $this->assertEquals('demo', $domain->getName());
        $this->assertEquals('', $domain->getSub());
        $this->assertEquals(false, $domain->isKnown());
        $this->assertEquals(false, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(true, $domain->isTest());
    }

    public function testSubSubDemoLocalhost(): void
    {
        $domain = new Domain('sub.sub.demo.localhost');

        $this->assertEquals('sub.sub.demo.localhost', $domain->get());
        $this->assertEquals('localhost', $domain->getTLD());
        $this->assertEquals('', $domain->getSuffix());
        $this->assertEquals('', $domain->getRegisterable());
        $this->assertEquals('demo', $domain->getName());
        $this->assertEquals('sub.sub', $domain->getSub());
        $this->assertEquals(false, $domain->isKnown());
        $this->assertEquals(false, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(true, $domain->isTest());
    }

    public function testSubDemoLocalhost(): void
    {
        $domain = new Domain('sub.demo.localhost');

        $this->assertEquals('sub.demo.localhost', $domain->get());
        $this->assertEquals('localhost', $domain->getTLD());
        $this->assertEquals('', $domain->getSuffix());
        $this->assertEquals('', $domain->getRegisterable());
        $this->assertEquals('demo', $domain->getName());
        $this->assertEquals('sub', $domain->getSub());
        $this->assertEquals(false, $domain->isKnown());
        $this->assertEquals(false, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(true, $domain->isTest());
    }

    public function testUTF(): void
    {
        $domain = new Domain('אשקלון.קום');

        $this->assertEquals('אשקלון.קום', $domain->get());
        $this->assertEquals('קום', $domain->getTLD());
        $this->assertEquals('קום', $domain->getSuffix());
        $this->assertEquals('אשקלון.קום', $domain->getRegisterable());
        $this->assertEquals('אשקלון', $domain->getName());
        $this->assertEquals('', $domain->getSub());
        $this->assertEquals(true, $domain->isKnown());
        $this->assertEquals(true, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(false, $domain->isTest());
    }

    public function testUTFSubdomain(): void
    {
        $domain = new Domain('חדשות.אשקלון.קום');

        $this->assertEquals('חדשות.אשקלון.קום', $domain->get());
        $this->assertEquals('קום', $domain->getTLD());
        $this->assertEquals('קום', $domain->getSuffix());
        $this->assertEquals('אשקלון.קום', $domain->getRegisterable());
        $this->assertEquals('אשקלון', $domain->getName());
        $this->assertEquals('חדשות', $domain->getSub());
        $this->assertEquals(true, $domain->isKnown());
        $this->assertEquals(true, $domain->isICANN());
        $this->assertEquals(false, $domain->isPrivate());
        $this->assertEquals(false, $domain->isTest());
    }

    public function testPrivateTLD(): void
    {
        $domain = new Domain('blog.potager.org');

        $this->assertEquals('blog.potager.org', $domain->get());
        $this->assertEquals('org', $domain->getTLD());
        $this->assertEquals('potager.org', $domain->getSuffix());
        $this->assertEquals('blog.potager.org', $domain->getRegisterable());
        $this->assertEquals('blog', $domain->getName());
        $this->assertEquals('', $domain->getSub());
        $this->assertEquals(true, $domain->isKnown());
        $this->assertEquals(false, $domain->isICANN());
        $this->assertEquals(true, $domain->isPrivate());
        $this->assertEquals(false, $domain->isTest());
    }

    public function testHTTPException1(): void
    {
        $this->expectException(Exception::class);

        new Domain('http://www.facbook.com');
    }

    public function testHTTPException2(): void
    {
        $this->expectException(Exception::class);

        new Domain('http://facbook.com');
    }

    public function testHTTPSException1(): void
    {
        $this->expectException(Exception::class);

        new Domain('https://www.facbook.com');
    }

    public function testHTTPSException2(): void
    {
        $this->expectException(Exception::class);

        new Domain('https://facbook.com');
    }
}

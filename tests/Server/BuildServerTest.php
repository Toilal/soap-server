<?php

namespace GoetasWebservices\SoapServices\SoapServer\Tests;

use GoetasWebservices\SoapServices\SoapCommon\Metadata\PhpMetadataGenerator;
use GoetasWebservices\SoapServices\SoapServer\ServerFactory;
use GoetasWebservices\WsdlToPhp\Tests\Generator;

class BuildServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServerFactory
     */
    protected $factory;

    public function setUp()
    {
        $namespaces = [
            'http://www.example.org/test/' => "Ex"
        ];
        $generator = new Generator($namespaces);
        $serializer = $generator->buildSerializer();

        $this->factory = new ServerFactory($namespaces, $serializer);

        $metadataGenerator = new PhpMetadataGenerator($namespaces);
        $this->factory->setMetadataGenerator($metadataGenerator);
    }

    public function testBuildServer()
    {
        $this->factory->getServer(__DIR__ . '/../Fixtures/Soap/test.wsdl');
    }

    public function testGetService()
    {
        $this->factory->getServer(__DIR__ . '/../Fixtures/Soap/test.wsdl', 'testSOAP');
    }

    /**
     * @expectedException  \GoetasWebservices\XML\WSDLReader\Exception\PortNotFoundException
     * @expectedExceptionMessage The port named XXX can not be found
     */
    public function testGetWrongPort()
    {
        $this->factory->getServer(__DIR__ . '/../Fixtures/Soap/test.wsdl', 'XXX');
    }

    /**
     * @expectedException  \GoetasWebservices\XML\WSDLReader\Exception\PortNotFoundException
     * @expectedExceptionMessage The port named testSOAP can not be found
     */
    public function testGetWrongService()
    {
        $this->factory->getServer(__DIR__ . '/../Fixtures/Soap/test.wsdl', 'testSOAP', 'alternativeTest');
    }

}

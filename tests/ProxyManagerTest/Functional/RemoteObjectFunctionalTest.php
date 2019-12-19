<?php

declare(strict_types=1);

namespace ProxyManagerTest\Functional;

<<<<<<< HEAD
=======
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
use PHPUnit\Framework\TestCase;
use ProxyManager\Factory\RemoteObject\Adapter\JsonRpc as JsonRpcAdapter;
use ProxyManager\Factory\RemoteObject\Adapter\XmlRpc as XmlRpcAdapter;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Generator\ClassGenerator;
use ProxyManager\Generator\Util\UniqueIdentifierGenerator;
use ProxyManager\GeneratorStrategy\EvaluatingGeneratorStrategy;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\ProxyGenerator\RemoteObjectGenerator;
use ProxyManagerTestAsset\ClassWithSelfHint;
use ProxyManagerTestAsset\OtherObjectAccessClass;
use ProxyManagerTestAsset\RemoteProxy\Foo;
use ProxyManagerTestAsset\RemoteProxy\FooServiceInterface;
use ProxyManagerTestAsset\RemoteProxy\RemoteServiceWithDefaultsInterface;
use ProxyManagerTestAsset\RemoteProxy\VariadicArgumentsServiceInterface;
use ProxyManagerTestAsset\VoidCounter;
use ReflectionClass;
use Zend\Server\Client;
<<<<<<< HEAD
=======

use function get_class;
use function random_int;
use function ucfirst;
use function uniqid;
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations

/**
 * Tests for {@see \ProxyManager\ProxyGenerator\RemoteObjectGenerator} produced objects
 *
 * @author Vincent Blanchon <blanchon.vincent@gmail.com>
 * @license MIT
 *
 * @group Functional
 * @coversNothing
 */
class RemoteObjectFunctionalTest extends TestCase
{
<<<<<<< HEAD
    protected function getXmlRpcAdapter($expectedValue, string $method, array $params) : XmlRpcAdapter
    {
        /* @var $client Client|\PHPUnit_Framework_MockObject_MockObject */
        $client = $this->getMockBuilder(Client::class)->setMethods(['call'])->getMock();
=======
    /**
     * @param mixed $expectedValue
     * @param string $method
     * @param mixed[] $params
     * @return XmlRpcAdapter
     */
    protected function getXmlRpcAdapter($expectedValue, string $method, array $params): XmlRpcAdapter
    {
        /** @var Client|MockObject $client */
        $client = $this->getMockBuilder(Client::class)->getMock();
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations

        $client
            ->expects(self::any())
            ->method('call')
            ->with(self::stringEndsWith($method), $params)
            ->will(self::returnValue($expectedValue));

        $adapter = new XmlRpcAdapter(
            $client,
            [
                 'ProxyManagerTestAsset\RemoteProxy\Foo.foo'
                     => 'ProxyManagerTestAsset\RemoteProxy\FooServiceInterface.foo'
            ]
        );

        return $adapter;
    }

    /**
<<<<<<< HEAD
     * @param mixed  $expectedValue
     * @param string $method
     * @param array  $params
     *
=======
     * @param mixed $expectedValue
     * @param string $method
     * @param mixed[] $params
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
     * @return JsonRpcAdapter
     */
    protected function getJsonRpcAdapter($expectedValue, string $method, array $params): JsonRpcAdapter
    {
<<<<<<< HEAD
        /* @var $client Client|\PHPUnit_Framework_MockObject_MockObject */
        $client = $this->getMockBuilder(Client::class)->setMethods(['call'])->getMock();
=======
        /** @var Client|MockObject $client */
        $client = $this->getMockBuilder(Client::class)->getMock();
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations

        $client
            ->expects(self::any())
            ->method('call')
            ->with(self::stringEndsWith($method), $params)
            ->will(self::returnValue($expectedValue));

        $adapter = new JsonRpcAdapter(
            $client,
            [
                 'ProxyManagerTestAsset\RemoteProxy\Foo.foo'
                    => 'ProxyManagerTestAsset\RemoteProxy\FooServiceInterface.foo'
            ]
        );

        return $adapter;
    }

    /**
     * @dataProvider getProxyMethods
     *
     * @param string|object $instanceOrClassName
<<<<<<< HEAD
     * @param string        $method
     * @param mixed[]       $params
     * @param mixed         $expectedValue
     */
    public function testXmlRpcMethodCalls($instanceOrClassName, string $method, array $params, $expectedValue) : void
    {
        $proxyName = $this->generateProxy($instanceOrClassName);
=======
     * @param string $method
     * @param array $passedParams
     * @param mixed[] $parametersForProxy
     * @param mixed $expectedValue
     *
     * @dataProvider getProxyMethods
     *
     * @psalm-template OriginalClass of object
     * @psalm-param class-string<OriginalClass>|OriginalClass $instanceOrClassName
     */
    public function testXmlRpcMethodCalls(
        $instanceOrClassName,
        string $method,
        array $passedParams,
        array $parametersForProxy,
        $expectedValue
    ): void {
        $proxy = (new RemoteObjectFactory($this->getXmlRpcAdapter($expectedValue, $method, $parametersForProxy)))
            ->createProxy($instanceOrClassName);
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations

        /* @var $proxy \ProxyManager\Proxy\RemoteObjectInterface */
        $proxy     = $proxyName::staticProxyConstructor($this->getXmlRpcAdapter($expectedValue, $method, $params));

<<<<<<< HEAD
        self::assertSame($expectedValue, call_user_func_array([$proxy, $method], $params));
=======
        self::assertIsCallable($callback);
        self::assertSame($expectedValue, $callback(...$passedParams));
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
    }

    /**
     * @dataProvider getProxyMethods
     *
     * @param string|object $instanceOrClassName
<<<<<<< HEAD
     * @param string        $method
     * @param mixed[]       $params
     * @param mixed         $expectedValue
     */
    public function testJsonRpcMethodCalls($instanceOrClassName, string $method, array $params, $expectedValue) : void
    {
        $proxyName = $this->generateProxy($instanceOrClassName);
=======
     * @param string $method
     * @param array $passedParams
     * @param mixed[] $parametersForProxy
     * @param mixed $expectedValue
     *
     * @dataProvider getProxyMethods
     *
     * @psalm-template OriginalClass of object
     * @psalm-param class-string<OriginalClass>|OriginalClass $instanceOrClassName
     */
    public function testJsonRpcMethodCalls(
        $instanceOrClassName,
        string $method,
        array $passedParams,
        array $parametersForProxy,
        $expectedValue
    ): void {
        $proxy = (new RemoteObjectFactory($this->getJsonRpcAdapter($expectedValue, $method, $parametersForProxy)))
            ->createProxy($instanceOrClassName);
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations

        /* @var $proxy \ProxyManager\Proxy\RemoteObjectInterface */
        $proxy     = $proxyName::staticProxyConstructor($this->getJsonRpcAdapter($expectedValue, $method, $params));

<<<<<<< HEAD
        self::assertSame($expectedValue, call_user_func_array([$proxy, $method], $params));
    }

    /**
=======
        self::assertIsCallable($callback);
        self::assertSame($expectedValue, $callback(...$passedParams));
    }

    /**
     * @param string|object $instanceOrClassName
     * @param string $publicProperty
     * @param mixed $propertyValue
     *
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
     * @dataProvider getPropertyAccessProxies
     *
     * @param string|object $instanceOrClassName
     * @param string        $publicProperty
     * @param string        $propertyValue
     */
    public function testJsonRpcPropertyReadAccess($instanceOrClassName, string $publicProperty, $propertyValue): void
    {
        $proxyName = $this->generateProxy($instanceOrClassName);

        /* @var $proxy \ProxyManager\Proxy\RemoteObjectInterface */
        $proxy     = $proxyName::staticProxyConstructor(
            $this->getJsonRpcAdapter($propertyValue, '__get', [$publicProperty])
        );

<<<<<<< HEAD
        /* @var $proxy \ProxyManager\Proxy\NullObjectInterface */
        self::assertSame($propertyValue, $proxy->$publicProperty);
=======
        self::assertSame($propertyValue, $proxy->{$publicProperty});
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
    }

    /**
     * Generates a proxy for the given class name, and retrieves its class name
     *
     * @param string|object $parentClassName
     */
    private function generateProxy($parentClassName) : string
    {
        $generatedClassName = __NAMESPACE__ . '\\' . UniqueIdentifierGenerator::getIdentifier('Foo');
        $generator          = new RemoteObjectGenerator();
        $generatedClass     = new ClassGenerator($generatedClassName);
        $strategy           = new EvaluatingGeneratorStrategy();

        $generator->generate(new ReflectionClass($parentClassName), $generatedClass);
        $strategy->generate($generatedClass);

        return $generatedClassName;
    }

    /**
     * Generates a list of object | invoked method | parameters | expected result
     *
     * @return array
     */
    public function getProxyMethods(): array
    {
        $selfHintParam = new ClassWithSelfHint();

        return [
            [
                'ProxyManagerTestAsset\RemoteProxy\FooServiceInterface',
                'foo',
                [],
<<<<<<< HEAD
                'bar remote'
=======
                [],
                'bar remote',
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
            ],
            [
                'ProxyManagerTestAsset\RemoteProxy\Foo',
                'foo',
                [],
<<<<<<< HEAD
                'bar remote'
=======
                [],
                'bar remote',
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
            ],
            [
                new Foo(),
                'foo',
                [],
<<<<<<< HEAD
                'bar remote'
=======
                [],
                'bar remote',
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
            ],
            [
                'ProxyManagerTestAsset\RemoteProxy\BazServiceInterface',
                'baz',
                ['baz'],
<<<<<<< HEAD
                'baz remote'
=======
                ['baz'],
                'baz remote',
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
            ],
            [
                new ClassWithSelfHint(),
                'selfHintMethod',
                [$selfHintParam],
<<<<<<< HEAD
                $selfHintParam
=======
                [$selfHintParam],
                $selfHintParam,
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
            ],
            [
                VariadicArgumentsServiceInterface::class,
                'method',
                ['aaa', 1, 2, 3, 4, 5],
                ['aaa', 1, 2, 3, 4, 5],
                true,
            ],
            [
                RemoteServiceWithDefaultsInterface::class,
                'optionalNonNullable',
                ['aaa'],
                ['aaa', ''],
                200
            ],
            [
                RemoteServiceWithDefaultsInterface::class,
                'optionalNullable',
                ['aaa'],
                ['aaa', null],
                200
            ]
        ];
    }

    /**
     * Generates proxies and instances with a public property to feed to the property accessor methods
     */
    public function getPropertyAccessProxies(): array
    {
        return [
            [
                FooServiceInterface::class,
                'publicProperty',
                'publicProperty remote',
            ],
        ];
    }

    /**
     * @group 276
     *
     * @dataProvider getMethodsThatAccessPropertiesOnOtherObjectsInTheSameScope
     *
     * @param object $callerObject
     * @param object $realInstance
     * @param string $method
     * @param string $expectedValue
     * @param string $propertyName
     */
    public function testWillInterceptAccessToPropertiesViaFriendClassAccess(
        $callerObject,
        $realInstance,
        string $method,
        string $expectedValue,
        string $propertyName
<<<<<<< HEAD
    ) : void {
        $proxyName = $this->generateProxy(get_class($realInstance));

        /* @var $adapter AdapterInterface|\PHPUnit_Framework_MockObject_MockObject */
=======
    ): void {
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
        $adapter = $this->createMock(AdapterInterface::class);

        $adapter
            ->expects(self::once())
            ->method('call')
            ->with(get_class($realInstance), '__get', [$propertyName])
            ->willReturn($expectedValue);

        /* @var $proxy OtherObjectAccessClass|RemoteObjectInterface */
        $proxy = $proxyName::staticProxyConstructor($adapter);

        /* @var $accessor callable */
        $accessor = [$callerObject, $method];

        self::assertSame($expectedValue, $accessor($proxy));
    }

    /**
     * @group 276
     *
     * @dataProvider getMethodsThatAccessPropertiesOnOtherObjectsInTheSameScope
     *
     * @param object $callerObject
     * @param object $realInstance
     * @param string $method
     * @param string $expectedValue
     * @param string $propertyName
     */
    public function testWillInterceptAccessToPropertiesViaFriendClassAccessEvenIfCloned(
        $callerObject,
        $realInstance,
        string $method,
        string $expectedValue,
        string $propertyName
<<<<<<< HEAD
    ) : void {
        $proxyName = $this->generateProxy(get_class($realInstance));

        /* @var $adapter AdapterInterface|\PHPUnit_Framework_MockObject_MockObject */
=======
    ): void {
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
        $adapter = $this->createMock(AdapterInterface::class);

        $adapter
            ->expects(self::once())
            ->method('call')
            ->with(get_class($realInstance), '__get', [$propertyName])
            ->willReturn($expectedValue);

        /* @var $proxy OtherObjectAccessClass|RemoteObjectInterface */
        $proxy = clone $proxyName::staticProxyConstructor($adapter);

        /* @var $accessor callable */
        $accessor = [$callerObject, $method];

        self::assertSame($expectedValue, $accessor($proxy));
    }

    /**
     * @group 327
     */
    public function testWillExecuteLogicInAVoidMethod(): void
    {
        $proxyName = $this->generateProxy(VoidCounter::class);

        /* @var $adapter AdapterInterface|\PHPUnit_Framework_MockObject_MockObject */
        $adapter = $this->createMock(AdapterInterface::class);

        $increment = random_int(10, 1000);

        $adapter
            ->expects(self::once())
            ->method('call')
            ->with(VoidCounter::class, 'increment', [$increment])
            ->willReturn(random_int(10, 1000));

        /* @var $proxy VoidCounter */
        $proxy = clone $proxyName::staticProxyConstructor($adapter);

        $proxy->increment($increment);
    }

<<<<<<< HEAD
    public function getMethodsThatAccessPropertiesOnOtherObjectsInTheSameScope() : \Generator
=======
    /**
     * @return Generator
     */
    public function getMethodsThatAccessPropertiesOnOtherObjectsInTheSameScope(): Generator
>>>>>>> 09bf1b9f... Adding more lang feature tests, adding functional tests, fixing PHPUnit 8 deprecations
    {
        foreach ((new \ReflectionClass(OtherObjectAccessClass::class))->getProperties() as $property) {
            $property->setAccessible(true);

            $propertyName = $property->getName();
            $realInstance = new OtherObjectAccessClass();
            $expectedValue = uniqid('', true);

            $property->setValue($realInstance, $expectedValue);

            yield OtherObjectAccessClass::class . '#$' . $propertyName => [
                new OtherObjectAccessClass(),
                $realInstance,
                'get' . ucfirst($propertyName),
                $expectedValue,
                $propertyName,
            ];
        }
    }
}

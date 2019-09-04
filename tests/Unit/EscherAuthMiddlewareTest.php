<?php

namespace Middleware\Auth\Escher\Tests\Unit;

use Escher\Escher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Middleware\Auth\Escher\Exceptions\InvalidConfigException;
use Middleware\Auth\Escher\Exceptions\JsonException;
use Middleware\Auth\Escher\Http\Middlewares\EscherAuthMiddleware;
use Middleware\Auth\Escher\Tests\Feature\BaseTestCase;

class EscherAuthMiddlewareTest extends BaseTestCase
{
    /**
     * @test
     */
    public function handle_escherKeyDBIsEmpty_throwsInvalidConfigException(): void
    {
        config(['escher.keyDB' => null]);
        $escher = Escher::create('test/credential/scope');
        $escherMiddleware = new EscherAuthMiddleware($escher);
        $request = new Request();
        $next = function () {
            return $this->createMock(Response::class);
        };

        $this->expectException(InvalidConfigException::class);
        $escherMiddleware->handle($request, $next);
    }

    /**
     * @test
     */
    public function handle_escherKeyDBIsEmptyString_throwsJsonException(): void
    {
        config(['escher.keyDB' => '']);
        $escher = Escher::create('test/credential/scope');
        $escherMiddleware = new EscherAuthMiddleware($escher);
        $request = new Request();
        $next = function () {
            return $this->createMock(Response::class);
        };

        $this->expectException(JsonException::class);
        $escherMiddleware->handle($request, $next);
    }

    /**
     * @test
     */
    public function handle_escherKeyDBIsNotValidJson_throwsJsonException(): void
    {
        config(['escher.keyDB' => 'invalid string']);
        $escher = Escher::create('test/credential/scope');
        $escherMiddleware = new EscherAuthMiddleware($escher);
        $request = new Request();
        $next = function () {
            return $this->createMock(Response::class);
        };

        $this->expectException(JsonException::class);
        $escherMiddleware->handle($request, $next);
    }
}

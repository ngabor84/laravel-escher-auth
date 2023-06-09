<?php declare(strict_types=1);

namespace Middleware\Auth\Escher\Http\Middlewares;

use ArrayObject;
use Closure;
use Escher\Escher;
use Illuminate\Http\Request;
use Middleware\Auth\Escher\Events\EscherAuthFailure;
use Middleware\Auth\Escher\Exceptions\InvalidConfigException;
use Middleware\Auth\Escher\Exceptions\JsonException;
use Throwable;

class EscherAuthMiddleware
{
    private Escher $escher;

    public function __construct(Escher $escher)
    {
        $this->escher = $escher;
    }

    public function handle(Request $request, Closure $next)
    {
        $serverVars = $request->server->all();
        $keyDB = $this->keyDB();

        try {
            $this->escher->authenticate($keyDB, $serverVars, $request->getContent());
        } catch (Throwable $e) {
            event(new EscherAuthFailure($request));

            return response()->json(['error' => $e->getMessage()], 401);
        }

        return $next($request);
    }

    private function keyDB(): ArrayObject
    {
        $keyDBJson = config('escher.keyDB', '{}');

        if ($keyDBJson === null) {
            throw new InvalidConfigException('Invalid KeyDB configuration');
        }

        $keyDB = json_decode($keyDBJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException('KeyDB JSON error: ' . json_last_error_msg(), json_last_error());
        }

        return new ArrayObject($keyDB);
    }
}

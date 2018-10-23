<?php declare(strict_types = 1);

namespace Middleware\Auth\Escher\Http\Middlewares;

use ArrayObject;
use Closure;
use Escher\Escher;
use Illuminate\Http\Request;
use Throwable;

class EscherAuthMiddleware
{
    private $escher;

    public function __construct(Escher $escher)
    {
        $this->escher = $escher;
    }

    // phpcs:disable SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
    public function handle(Request $request, Closure $next)
    {
        try {
            $serverVars = $request->server->all();
            $keyId = config('escher.keyId');
            $secret = config('escher.secret');
            $keyDB = new ArrayObject(array(
                $keyId => $secret
            ));

            $this->escher->authenticate($keyDB, $serverVars);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
    // phpcs:enable
}

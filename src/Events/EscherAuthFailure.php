<?php declare(strict_types=1);

namespace Middleware\Auth\Escher\Events;

use Illuminate\Http\Request;

class EscherAuthFailure
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $response = $next($request);

    //if (app()->environment('local')) {
    $log = [
      'URI' => $request->getUri(),
      'METHOD' => $request->getMethod(),
      'REQUEST_BODY' => $request->all(),
      'RESPONSE' => $response->getContent()
    ];

    Log::info(json_encode($log));

    return $response;
    //}
  }
}

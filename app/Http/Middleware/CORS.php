<?php
namespace App\Http\Middleware;

use Closure;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'GET, OPTIONS, POST, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '60',
            'Access-Control-Allow-Headers'     => 'Origin, X-Requested-With, Content-Type, Accept, Authorization',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response(null, 200, $headers);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            //$response->header($key, $value);
            $response->headers->set($key, $value);
        }
        return $response;

    }
}

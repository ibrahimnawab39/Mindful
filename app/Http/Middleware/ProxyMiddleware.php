<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProxyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $baseUrl)
    {
        $url = $baseUrl . '/' . ltrim($request->path(), '/');
        $method = $request->method();
        $headers = $request->headers->all();
        $body = $request->getContent();

        $client = new Client();

        $response = $client->request($method, $url, [
            'headers' => $headers,
            'body' => $body,
            'http_errors' => false,
        ]);

        $content = $response->getBody()->getContents();
        $statusCode = $response->getStatusCode();
        $headers = $response->getHeaders();

        return response($content, $statusCode, $headers);
    }
}

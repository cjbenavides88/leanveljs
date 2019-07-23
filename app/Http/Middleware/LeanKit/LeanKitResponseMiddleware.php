<?php

namespace App\Http\Middleware\LeanKit;

use Closure;

class LeanKitResponseMiddleware
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
        $response = $next($request);
        if($response->getStatusCode() != 200){
            $content = json_decode($response->getContent());

            dd($content);

            try{
                $response_content = [
                    'errors'    => [$content->error],
                    'message'   => $content->message,
                ];
            }catch(\Exception $exception){
                $response_content = [
                    'errors'    => ['Exception: ' . $exception->getCode()],
                    'message'   => $exception->getMessage(),
                ];
            }
            return response($response_content,$response->getStatusCode());
        }
        return response($response->getContent(),$response->getStatusCode());
    }
}

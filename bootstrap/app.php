<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    }) 
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            $status = 422;
            $reason = $e->validator->errors()->first() ?: 'Validation failed.';

            return response()->json([
                'status_code' => $status,
                'reason' => $reason,
            ], $status);
        });

        $exceptions->render(function (AuthenticationException $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            $status = 401;

            return response()->json([
                'status_code' => $status,
                'reason' => 'Unauthenticated.',
            ], $status);
        });

        $exceptions->render(function (AuthorizationException $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            $status = 403;

            return response()->json([
                'status_code' => $status,
                'reason' => $e->getMessage() ?: 'Forbidden.',
            ], $status);
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            $status = 404;

            return response()->json([
                'status_code' => $status,
                'reason' => 'Not Found.',
            ], $status);
        });

        $exceptions->render(function (Throwable $e, $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;
            $reason = $status >= 500
                ? 'Internal Server Error.'
                : ($e->getMessage() ?: 'Request failed.');

            return response()->json([
                'status_code' => $status,
                'reason' => $reason,
            ], $status);
        });
    })->create();

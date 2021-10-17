<?php

namespace Txsoura\Core\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class CoreHandler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json([
                'message' => trans('core::message.not_found'),
                'error' => trans('core::message.entry_not_found', ['model' => str_replace('App\\Models\\', '', $exception->getModel())])
            ], 404);
        }

        if ($exception instanceof RelationNotFoundException && $request->wantsJson()) {
            return response()->json([
                'message' => trans('core::message.not_found'),
                'error' => trans('core::message.relation_not_found')
            ], 404);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return response()->json([
                'message' => trans('core::message.no_permission'),
                'error' => trans('core::message.access_denied')
            ], 403);
        }

        if ($exception instanceof InvalidSignatureException && $request->wantsJson()) {
            return response()->json([
                'error' => trans('core::message.invalid_signature')
            ], 403);
        }

        if ($exception instanceof ThrottleRequestsException) {
            return response()->json([
                'error' => trans('core::message.too_many_requests')
            ], 429);
        }

        if ($exception->getMessage() === 'CSRF token mismatch.') {
            return response()->json([
                'error' => trans('core::message.invalid_csrf_token')
            ], 419);
        }

        if ($exception instanceof UnauthorizedHttpException) {

            if ($exception->getMessage() === 'User not found') {
                return response()->json([
                    'message' => trans('core::message.not_found'),
                    'error' => trans('core::message.user_not_found')
                ], 404);
            }

            //To log untreated unauthorized exceptions
            Log::error('UNAUTHORIZED_EXCEPTION:' . $exception->getMessage());
            return response()->json([
                'message' => trans('core::message.unauthenticated')
            ], 401);
        }

        if ($exception instanceof MethodNotAllowedHttpException && $request->wantsJson()) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 405);
        }

        if ($exception instanceof NotFoundHttpException && $request->wantsJson()) {
            return response()->json([
                'message' => trans('core::message.not_found'),
                'error' => trans('core::message.route_not_found')
            ], 404);
        }


        if ($exception instanceof RouteNotFoundException && $request->wantsJson()) {
            return response()->json([
                'message' => trans('core::message.not_found'),
                'error' => trans('core::message.route_not_found')
            ], 404);
        }
    }
}

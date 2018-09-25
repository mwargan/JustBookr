<?php

namespace App\Helpers;

class ExceptionHelper
{
    /**
     * Handle exception.
     *
     * @param Illuminate\Http\Request\Request $request
     *
     * @return array
     */
    public static function handleError($exception, $request)
    {
        if ($request->wantsJson()) {
            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                $message = $exception->errors();
            } else {
                report($exception);
                $message = ['error' => $exception->getMessage()];
            }

            return response()->json(['errors' => $message], 422);
        }

        return back()->withInput()
            ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
    }
}

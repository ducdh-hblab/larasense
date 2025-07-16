<?php

if (!function_exists('is_debug')) {
    function is_debug()
    {
        return config('app.debug') == true;
    }
}

if (!function_exists('setting')) {
    function setting($key = '', $default = null)
    {
        return \App\Facades\Setting::get($key, $default);
    }
}

if (!function_exists('s3url')) {
    function s3url($path)
    {
        if (empty($path)) {
            return '';
        }

        return asset('storage/' . $path);
        return \Illuminate\Support\Facades\Storage::disk('s3')->url($path);
    }
}

if (!function_exists('the_admin')) {
    function the_admin()
    {
        return setting('admin_email', config('app.admin_email'));
    }
}

if (!function_exists('api_throw')) {
    function api_throw($code, $message)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()
            ->json([
                'code' => $code,
                'message' => $message,
            ], $code));
    }
}

if (!function_exists('the_name')) {
    function the_name()
    {
        return setting('name', config('app.name'));
    }
}

if (!function_exists('the_title')) {
    function the_title()
    {
        return setting('title', config('app.name'));
    }
}

if (!function_exists('the_desc')) {
    function the_desc()
    {
        return setting('description', config('app.title'));
    }
}

if (!function_exists('the_keywords')) {
    function the_keywords()
    {
        return setting('keywords', config('app.name'));
    }
}

if (!function_exists('the_copyright')) {
    function the_copyright()
    {
        return 'Copyright &copy; ' . now()->year . ' ' . the_name() . '.';
    }
}

if (!function_exists('the_facebook')) {
    function the_facebook()
    {
        return true;
    }
}

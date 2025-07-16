<?php

namespace App\Facades;

use App\Enums\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SettingFacade
{
    const CONFIG_TAG = 'config';

    public function get($key = '', $forceUpdate = false)
    {
        $username = config('app.username');
        $userId = config('app.user_id');
        $args = explode('.', $key);
        $tableName = $args[0];
        $fieldName = $args[1] ?? null;

        if (empty($fieldName)) {
            return App::SETTINGS[$key] ?? '';
        }

        if (!$forceUpdate) {
            $data = $this->getConfigCache($username, $key);
            if ($data) {
                return $data;
            }
        }

        $modelName = 'App\\Models\\' . Str::studly(Str::singular($tableName));
        $modelInstance = new $modelName;
        $setting = $modelInstance->where('id', $userId)->first();

        $value = App::SETTINGS[$key] ?? '';
        if ($setting) {
            $fieldValue = $setting->{$fieldName} ?? '';
            if ($fieldValue) {
                $value = $fieldValue;
            }
        }

        $this->updateConfigCache($username, $key, $value);

        return $value;
    }

    public function hasConfigCache($tag, $key): bool
    {
        return Cache::tags($tag)->has($key);
    }

    public function getConfigCache($tag, $key)
    {
        return Cache::tags($tag)->get($key);
    }

    public function updateConfigCache($tag, $key, $value)
    {
        $expiresAt = now()->addMonth();
        Cache::tags($tag)->put($key, $value, $expiresAt);
    }
}

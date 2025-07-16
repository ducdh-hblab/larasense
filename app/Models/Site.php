<?php

namespace App\Models;

use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Site extends Model
{
    use HasFactory;

    public const CACHE_KEY = 'setting_';

    public $fillable = [
        'title',
        'heading',
        'favicon',
        'logo_image',
        'logo_text',
        'theme',
        'template',
        'language',
        'fullwidth',
        'color',
        'font',
        'background',
        'background_color',
        'background_image',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'navigation',
        'records_per_page',

        'ga_id',
        'gtag',
        'fathom_id',
    ];

    public $casts = [
        'id' => 'integer',
    ];

    protected $dispatchesEvents = [
    ];
}

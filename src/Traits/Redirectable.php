<?php

namespace CodencoDev\UrlRedirector\Traits;

use CodencoDev\UrlRedirector\Models\RedirectUrl;
use CodencoDev\UrlRedirector\UrlRedirectorFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

trait Redirectable
{
    public static function bootRedirectable()
    {
        static::updating(function (Model $model) {
//            if($model->exists)
//            dd($model,$model->getDirty(),$model->getCurrentShowUrl());
            if (collect($model->getDirty())
                    ->has($model
                        ->getRouteKeyName())) {
                UrlRedirectorFacade::save($model->getCurrentShowUrl(), $model);
            }
        });
    }

    public function redirect_urls(): MorphMany
    {
        return $this->morphMany(RedirectUrl::class, 'redirectable');
    }

    public function getCurrentShowUrl(): string
    {
        return route($this->getResourceName().'.show', $this);
    }

    public function getResourceName()
    {
        return Str::plural(Str::kebab((new \ReflectionClass($this))->getShortName()));
    }
}

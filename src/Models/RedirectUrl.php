<?php

namespace CodencoDev\UrlRedirector\Models;

use CodencoDev\UrlRedirector\Enums\RedirectUrlTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RedirectUrl extends Model
{
    protected $guarded = [];

    public static function add(string $origin, Model | string $destination, ?string $code = '301'): self
    {
        $code = $code ?? '301';
        if ($destination instanceof Model) {
            $redirectUrl = self::create([
                'origin_url' => $origin,
                'http_code' => $code,
                'type' => RedirectUrlTypeEnum::model(),
            ]);

            $redirectUrl->redirectable()->save($destination);
        } elseif (is_string($destination)) {
            $redirectUrl = self::create([
                    'origin_url' => $origin,
                    'http_code' => $code,
                    'type' => RedirectUrlTypeEnum::url(),
                    'destination_url' => $destination,
                ]);
        }

        return $redirectUrl;
    }

    public function redirectable(): MorphTo
    {
        return $this->morphTo();
    }
}

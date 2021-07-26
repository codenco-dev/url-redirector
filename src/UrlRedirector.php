<?php

namespace CodencoDev\UrlRedirector;

use CodencoDev\UrlRedirector\Models\RedirectUrl;
use Illuminate\Database\Eloquent\Model;

class UrlRedirector
{
    public function __construct(public ?RedirectUrl $redirectUrl = null)
    {
    }

    public function save(string $origin_url, Model | string $destination, ?string $code = null): bool
    {
        $this->redirectUrl = RedirectUrl::add($origin_url, $destination, $code);

        return ($this->redirectUrl?->exists);
    }

    public function get($origin)
    {
        $this->redirectUrl = RedirectUrl::where('origin_url', $origin)->first();

        return $this;
    }

    public function has(string $url): bool
    {
        return RedirectUrl::where('origin_url', $url)->exists();
    }

    public function getCode()
    {
        return $this->redirectUrl->http_code;
    }
}

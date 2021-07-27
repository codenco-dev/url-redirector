<?php

namespace CodencoDev\UrlRedirector;

use CodencoDev\UrlRedirector\Enums\RedirectUrlTypeEnum;
use CodencoDev\UrlRedirector\Models\RedirectUrl;
use Illuminate\Database\Eloquent\Model;

class UrlRedirector
{
    public function __construct(public ?RedirectUrl $redirectUrl = null)
    {
    }

    public function save(string $origin_url, Model | string $destination, ?int $code = null): bool
    {
        $origin_url = $this->pathUrl($origin_url);
        if(is_string($destination)){
            $destination = $this->pathUrl($destination);
        }
        $this->redirectUrl = RedirectUrl::add($origin_url,$destination, $code);

        return ($this->redirectUrl?->exists);
    }

    public function get($origin)
    {
        $origin = $this->pathUrl($origin);
        $this->redirectUrl = RedirectUrl::where('origin_url', $origin)->first();

        return $this;
    }

    public function pathUrl($url):string
    {
        return parse_url($url)['path'] ?? '/';
    }

    public function has(string $url): bool
    {
        $url = $this->pathUrl($url);
        return RedirectUrl::where('origin_url', $this->pathUrl($url))->exists();
    }

    public function getCode()
    {
        return $this->redirectUrl->http_code;
    }

    public function getRedirectionUrl(string $url): array
    {
        $url = $this->pathUrl($url);
        if ($this->get($url)->redirectUrl?->type == RedirectUrlTypeEnum::url()
        && $this->get($url)->redirectUrl?->destination_url) {
            return [$url => [$this->get($url)->redirectUrl?->destination_url,$this->get($url)->redirectUrl?->http_code]];
        }

        if ($this->get($url)->redirectUrl?->type == RedirectUrlTypeEnum::model()
            && $this->get($url)->redirectUrl?->redirectable?->getCurrentShowUrl()) {
            return [$url => [$this->get($url)->redirectUrl?->redirectable?->getCurrentShowUrl(),$this->get($url)->redirectUrl?->http_code]];
        }

        return [''];
    }
}

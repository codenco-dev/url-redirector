<?php

namespace CodencoDev\UrlRedirector;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool has(string $origin_url)
 * @method static UrlRedirector save(string $origin_url,Model|string $destination,string $code='302')
 * @method static UrlRedirector get(string $origin_url)
 * @method static Model|string getDestination(string $origin_url)
 * @see \CodencoDev\UrlRedirector\UrlRedirector
 */
class UrlRedirectorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'url-redirector';
    }
}

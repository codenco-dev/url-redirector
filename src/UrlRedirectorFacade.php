<?php

namespace CodencoDev\UrlRedirector;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodencoDev\UrlRedirector\UrlRedirector
 */
class UrlRedirectorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'url-redirector';
    }
}

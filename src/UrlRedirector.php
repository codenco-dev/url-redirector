<?php

namespace CodencoDev\UrlRedirector;

use CodencoDev\UrlRedirector\Models\RedirectUrl;
use Illuminate\Database\Eloquent\Model;

class UrlRedirector
{

    public function __construct(public string $origin,public string $code, Model|string $destination)
    {
    }


    public function save(string $origin_url,Model|string $destination, ?string $code=null)
    {
        RedirectUrl::add($origin_url,$destination,$code);
    }

    public function get($origin)
    {
        $redirect = RedirectUrl::where('origin',$origin)->get();
        $this->origin = $redirect->origin_url;
//        if($redirect->type == destination
        $this->destination = $redirect->origin_url;
    }

    public function has(string $url):bool
    {
        return RedirectUrl::where('origin_url',$url)->exists();
    }
}

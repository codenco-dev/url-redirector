<?php


namespace CodencoDev\UrlRedirector\Tests\Models;


use CodencoDev\UrlRedirector\Traits\Redirectable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    use Redirectable;
    protected $guarded=[];
}
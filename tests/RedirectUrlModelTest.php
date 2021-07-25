<?php

namespace CodencoDev\UrlRedirector\Tests;

use CodencoDev\EloquentModelTester\HasModelTester;
use CodencoDev\UrlRedirector\Enums\RedirectUrlTypeEnum;
use CodencoDev\UrlRedirector\Models\RedirectUrl;
use CodencoDev\UrlRedirector\Tests\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedirectUrlModelTest extends TestCase
{
    use RefreshDatabase;
    use HasModelTester;

    /** @test */
    public function has_model_redirect_url_with_good_structure()
    {
        $this->assertTrue(true);
        $this->modelTestable(RedirectUrl::class)
            ->assertHasColumns([
           'origin_url',
           'destination_url',
        ]);
    }

    /** @test */
    public function it_can_store_with_url()
    {
        $origin = 'origin';
        $destination = 'destination';
        $code = '301';
        RedirectUrl::add($origin, $destination, $code);

        $this->assertDatabaseHas('redirect_urls', [
            'origin_url' => $origin,
            'type' => RedirectUrlTypeEnum::url(),
        ]);
    }

    /** @test */
    public function it_can_store_with_model()
    {
        $origin = 'origin';
        $destination = 'destination';
        $code = '301';
        $redirectUrl = RedirectUrl::add($origin, Post::create(), $code);

        $this->assertDatabaseHas('redirect_urls', [
            'origin_url' => $origin,
            'type' => RedirectUrlTypeEnum::model(),
        ]);
    }
}

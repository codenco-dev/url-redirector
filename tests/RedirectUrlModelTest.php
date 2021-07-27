<?php

namespace CodencoDev\UrlRedirector\Tests;

use CodencoDev\EloquentModelTester\HasModelTester;
use CodencoDev\UrlRedirector\Enums\RedirectUrlTypeEnum;
use CodencoDev\UrlRedirector\Models\RedirectUrl;
use CodencoDev\UrlRedirector\Tests\Models\Post;
use CodencoDev\UrlRedirector\Tests\Models\WithSlugPost;
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
        $redirectUrl = RedirectUrl::add($origin, WithSlugPost::create(), $code);

        $this->assertDatabaseHas('redirect_urls', [
            'origin_url' => $origin,
            'type' => RedirectUrlTypeEnum::model(),
        ]);
    }

    /** @test */
    public function it_cannot_have_two_same_origin_url_with_url_destination()
    {
        $this->assertCount(0, RedirectUrl::all());
        $origin = 'origin';
        $destination = 'destination';
        $destination2 = 'destination23';
        $code = '301';
        $redirectUrl = RedirectUrl::add($origin, $destination, $code);
        $redirectUrl = RedirectUrl::add($origin, $destination2, $code);

        $this->assertDatabaseHas('redirect_urls', [
            'origin_url' => $origin,
            'type' => RedirectUrlTypeEnum::url(),
            'destination_url' => $destination2,
        ]);
        $this->assertDatabaseMissing('redirect_urls', [
            'origin_url' => $origin,
            'type' => RedirectUrlTypeEnum::url(),
            'destination_url' => $destination,
        ]);
    }

    /** @test */
    public function it_cannot_have_two_same_origin_url_with_model_destination()
    {
        $this->assertCount(0, RedirectUrl::all());
        $origin = 'origin';
        $destination = 'destination';
        $destination2 = 'destination23';
        $code = '301';
        $p = Post::create();
        $p2 = Post::create();
        $redirectUrl = RedirectUrl::add($origin, $p, $code);
        $redirectUrl = RedirectUrl::add($origin, $p2, $code);

        $this->assertDatabaseHas('redirect_urls', [
            'origin_url' => $origin,
            'type' => RedirectUrlTypeEnum::model(),
            'redirectable_id' => $p2->id,
        ]);
        $this->assertDatabaseMissing('redirect_urls', [
            'origin_url' => $origin,
            'type' => RedirectUrlTypeEnum::model(),
            'redirectable_id' => $p->id,
        ]);
    }
}

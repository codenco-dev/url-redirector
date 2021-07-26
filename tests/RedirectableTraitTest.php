<?php


namespace CodencoDev\UrlRedirector\Tests;


use CodencoDev\UrlRedirector\Models\RedirectUrl;
use CodencoDev\UrlRedirector\Tests\Models\Post;
use CodencoDev\UrlRedirector\Tests\Models\WithSlugPost;


class RedirectableTraitTest extends TestCase
{
    /** @test */

    function it_can_get_resource_name()
    {
        $this->assertEquals((new Post)->getResourceName(),"posts");
        $this->assertnotEquals((new Post)->getResourceName(),"post");
        $this->assertEquals((new WithSlugPost)->getResourceName(),"with-slug-posts");
        $this->assertnotEquals((new WithSlugPost)->getResourceName(),"with-slug-post");
    }



    /** @test */
    function it_must_not_have_record_if_url_not_changed()
    {
        $post = WithSlugPost::create(['name' => 'test']);
        $post->name = "test";
        $post->save();
        $this->assertDatabaseCount("redirect_urls",0);
        $this->assertCount(0,$post->redirect_urls()->get());
    }

    /** @test */
    function it_must_have_record_if_url_changed()
    {
        $post = WithSlugPost::create(['name' => 'test']);
        $post->name = "test2";
        $post->save();
        $this->assertDatabaseCount('redirect_urls',1);
        $this->assertCount(1,$post->redirect_urls()->get());
    }
}
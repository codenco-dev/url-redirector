<?php

namespace CodencoDev\UrlRedirector\Tests;

use CodencoDev\UrlRedirector\Tests\Models\WithSlugPost;
use CodencoDev\UrlRedirector\UrlRedirectorFacade;
use Illuminate\Support\Str;

class RedirectorTest extends TestCase
{
    /** @test */
    public function it_can_record_url_for_model()
    {
        $origin = 'origin';
        $destination = WithSlugPost::create();
        ;
        UrlRedirectorFacade::save($origin, $destination);

        $this->assertTrue(UrlRedirectorFacade::has($origin));
    }

    /** @test */
    public function it_can_record_url_for_string()
    {
        $origin = 'origin';
        $destination = 'destination';
        UrlRedirectorFacade::save($origin, $destination);
        $this->assertTrue(UrlRedirectorFacade::has($origin));
    }

    /** @test */
    public function it_can_record_with_code()
    {
        $origin = 'origin';
        $destination = 'destination';
        $code = '302';
        UrlRedirectorFacade::save($origin, $destination, $code);
        $this->assertTrue(UrlRedirectorFacade::has($origin));
        $this->assertEquals((UrlRedirectorFacade::get($origin))->getCode(), $code);
    }

    /** @test */
    public function it_can_retrieve_recorded_url()
    {
        UrlRedirectorFacade::save('test', 'destination');
        $this->assertTrue(UrlRedirectorFacade::has('test'));
    }

    /** @test */
    public function it_cannot_retrieve_unrecorded_url()
    {
        UrlRedirectorFacade::save('test1', 'destination');
        $this->assertFalse(UrlRedirectorFacade::has('test2'));
    }

    /** @test */
    public function can_retrieve_good_url_for_a_model()
    {
        $old_url = 'test_url';

        $p = WithSlugPost::create(['name' => 'test']);

        UrlRedirectorFacade::save($old_url, $p);

        $model = (UrlRedirectorFacade::get($old_url))->redirectUrl->redirectable;

        $this->assertTrue(UrlRedirectorFacade::has($old_url));


        $this->assertEquals($p->getAttributes(), $model->getAttributes());

        $this->assertInstanceOf($p::class, $model);
        $this->assertEquals($p->id, $model->id);
    }

    /** @test */
    public function can_retrieve_good_url_for_another()
    {
        $old_url = 'old_url';
        $new_url = 'new_url';


        UrlRedirectorFacade::save($old_url, $new_url);

        $url = (UrlRedirectorFacade::get($old_url))->redirectUrl->destination_url;

        $this->assertTrue(UrlRedirectorFacade::has($old_url));

        $this->assertEquals($new_url, $url);
        $this->assertIsString($url);
    }

    /** @test */
    public function it_can_have_string_url()
    {
        UrlRedirectorFacade::save('origin_url', 'destination_url','405');
        $this->assertEquals([
            'origin_url' => ['destination_url','405']
        ], UrlRedirectorFacade::getRedirectionUrl('origin_url'));
    }

    /** @test */
    public function it_can_have_model_url()
    {
        $p = WithSlugPost::create(['name' => 'test']);
        UrlRedirectorFacade::save('origin_url', $p,'405');

        $this->assertEquals([
            'origin_url' => ['http://localhost/with-slug-posts/test','405'],
        ], UrlRedirectorFacade::getRedirectionUrl('origin_url'));
    }

    /** @test */

    function domain_are_not_save()
    {
        $old_url = 'http://test.com/folder/page_old.htm';
        $new_url = 'http://test.com/folder/page_new.htm';


        UrlRedirectorFacade::save($old_url, $new_url);

        $url = (UrlRedirectorFacade::get($old_url))->redirectUrl->origin_url;
        $url2 = (UrlRedirectorFacade::get($old_url))->redirectUrl->destination_url;

        $this->assertTrue(UrlRedirectorFacade::has($old_url));

        $this->assertEquals('/folder/page_old.htm', $url);
        $this->assertEquals('/folder/page_new.htm', $url2);
    }

    /** @test */

    function it_can_delete_domain_on_http_url()
    {
        $url = 'http://test.com/folder/url1.htm';

        $this->assertEquals('/folder/url1.htm',UrlRedirectorFacade::pathUrl($url));
    }

    /** @test */

    function it_can_delete_domain_on_https_url()
    {
        $url = 'https://test.com/folder/page';

        $this->assertEquals('/folder/page',UrlRedirectorFacade::pathUrl($url));
    }

    /** @test */

    function it_can_delete_domain_on_without_domain_url()
    {
        $url = '/folder/page';

        $this->assertEquals($url,UrlRedirectorFacade::pathUrl($url));
    }

    /** @test */

    function it_can_delete_domain_on_without_path_url()
    {
        $url = 'https://test.com';

        $this->assertEquals('/',UrlRedirectorFacade::pathUrl($url));
    }
}

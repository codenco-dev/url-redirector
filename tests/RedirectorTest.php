<?php

namespace CodencoDev\UrlRedirector\Tests;

use CodencoDev\UrlRedirector\Tests\Models\WithSlugPost;
use CodencoDev\UrlRedirector\UrlRedirectorFacade;
use Illuminate\Database\Eloquent\Model;

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

    /** @tes */
    public function can_retrieve_good_url_for_a_model()
    {
        $old_url = 'test_url';

        $p = WithSlugPost::create(['name' => 'test']);

        UrlRedirectorFacade::save($old_url, $p);

        $model = UrlRedirectorFacade::getDestination($old_url);

        $this->assertTrue(UrlRedirectorFacade::has($old_url));


        $this->assertSame($p, $model);
        $this->assertInstanceOf(Model::class, $model::class);
        $this->assertInstanceOf($p::class, $model::class);
        $this->assertEquals($p->id, $model->id);
    }

    public function can_retrieve_good_url_for_another()
    {
        $old_url = 'old_url';
        $new_url = 'new_url';


        UrlRedirectorFacade::save($old_url, $new_url);

        $url = UrlRedirectorFacade::getDestination($old_url);

        $this->assertTrue(UrlRedirectorFacade::has($old_url));

        $this->assertSame($new_url, $url);
        $this->assertIsString($url);
    }
}

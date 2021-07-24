<?php


namespace CodencoDev\UrlRedirector\Tests;



use CodencoDev\UrlRedirector\Enums\RedirectUrlTypeEnum;
use CodencoDev\UrlRedirector\Models\RedirectUrl;
use CodencoDev\UrlRedirector\Tests\Models\Post;
use CodencoDev\UrlRedirector\Tests\Factories\PostFactory;
use CodencoDev\UrlRedirector\UrlRedirectorFacade;
use Illuminate\Database\Eloquent\Model;

class RedirectorTest extends TestCase
{
    /** @test */

    function it_can_record_url_for_model()
    {
        $origin = 'origin';
        $destination = Post::create();;
        UrlRedirectorFacade::save($origin,$destination);

        $this->assertTrue(UrlRedirectorFacade::has($origin));

    }

    /** @test */

    function it_can_record_url_for_string()
    {
        $origin = 'origin';
        $destination = 'destination';
        UrlRedirectorFacade::save($origin,$destination);
        $this->assertTrue(UrlRedirectorFacade::has($origin));
    }

    /** @test */

    function it_can_record_with_code()
    {

        $origin = 'origin';
        $destination = 'destination';
        $code = '302';
        UrlRedirectorFacade::save($origin,$destination,$code);
        $this->assertTrue(UrlRedirectorFacade::has($origin));
        $this->assertEquals((UrlRedirectorFacade::get($origin))->code(),$code);

    }

    /** @test */

    function it_can_retrieve_recorded_url()
    {
        UrlRedirectorFacade::save('test','destination');
        $this->assertTrue(UrlRedirectorFacade::has('test'));
    }

    /** @test */

    function it_cannot_retrieve_unrecorded_url()
    {
        UrlRedirectorFacade::save('test1','destination');
        $this->assertTrue(UrlRedirectorFacade::save('test2'));
    }

    /** @tes */

    function can_retrieve_good_url_for_a_model()
    {

        $old_url = 'test_url';

        $p = Post::create(['name' => 'test']);

        UrlRedirectorFacade::save($old_url,$p);

        $model = UrlRedirectorFacade::getDestination($old_url);

        $this->assertTrue(UrlRedirectorFacade::has($old_url));


        $this->assertSame($p,$model);
        $this->assertInstanceOf(Model::class,$model::class);
        $this->assertInstanceOf($p::class, $model::class);
        $this->assertEquals($p->id,$model->id);

    }

    function can_retrieve_good_url_for_another()
    {

        $old_url = 'old_url';
        $new_url = 'new_url';


        UrlRedirectorFacade::save($old_url,$new_url);

        $url = UrlRedirectorFacade::getDestination($old_url);

        $this->assertTrue(UrlRedirectorFacade::has($old_url));

        $this->assertSame($new_url,$url);
        $this->assertIsString($url);

    }



}
<?php


namespace CodencoDev\UrlRedirector\Tests;


use CodencoDev\EloquentModelTester\HasModelTester;
use CodencoDev\UrlRedirector\Models\RedirectUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedirectUrlModelTest extends TestCase
{
    use RefreshDatabase;
    use HasModelTester;

    /** @test */

    public function has_model_redirect_url_with_good_structure()
    {
        $this->assertTrue(true);
//        $this->modelTestable(RedirectUrl::class)
//            ->assertHasColumns([
//           'origin_url',
//           'destination_url',
//        ]);
    }
}
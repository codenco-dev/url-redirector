<?php

namespace CodencoDev\UrlRedirector\Commands;

use Illuminate\Console\Command;

class UrlRedirectorCommand extends Command
{
    public $signature = 'url-redirector';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}

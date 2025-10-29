<?php

namespace App\Policies;

use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Directive;

class CspPolicy extends Basic
{
    public function configure()
    {

        $this
            ->addDirective(Directive::SCRIPT, [
                "'self'",
                "'unsafe-inline'",
                "'unsafe-hashes'",
                'https://cdn.jsdelivr.net',
                'https://code.jquery.com',
                'https://cdn.datatables.net'
            ])
            ->addDirective(Directive::STYLE, [
                "'self'",
                "'unsafe-inline'",
                "'unsafe-hashes'",
                'https://cdn.jsdelivr.net',
                'https://cdn.datatables.net'
            ])
            ->addDirective(Directive::IMG, [
                "'self'",
                'data:',
                'blob:',
                'https://*'
            ])
            ->addDirective(Directive::CONNECT, [
                "'self'",
                "https://cdn.jsdelivr.net",
                "https://cdn.datatables.net",
                "https://code.jquery.com"
            ])
            ->addDirective(Directive::FRAME, [
                "'self'",
                "https://www.youtube.com",
                "https://www.youtube-nocookie.com",
            ])
            ->addDirective(Directive::MEDIA, [
                "'self'",
                "https://www.youtube.com",
            ])
            ->addDirective(Directive::FONT, [
                "'self'",
                'https://cdn.jsdelivr.net'
            ]);
    }
}

<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyFileExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter('remote_file_exists', [$this, 'remoteFileExists']),
        ];
    }

    public function remoteFileExists($url)
    {
        $url = file_exists($url);

        return $url;
    }

}

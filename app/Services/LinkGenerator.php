<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class LinkGenerator
{
    public function generateLink(string $url): string
    {
        $hash = $this->generateHash();
        $urlParts = parse_url($url);

        $domain = $urlParts['scheme'] . '://' . $urlParts['host'];

        $firstFolder = '';

        if (isset($urlParts['path']) && $urlParts['path'] !== '/') {
            $trimmedPath = ltrim($urlParts['path'], '/');
            $pathParts = explode('/', $trimmedPath);
            $firstFolder = '/' . $pathParts[0];
        }

        $newUrl = $domain . $firstFolder . '/' . $hash;

        return $this->checkLinkUnique($newUrl);
    }

    protected function generateHash(): string
    {
        $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle($permittedChars), 0, 6);
    }

    protected function checkLinkUnique(string $url): string
    {
        $validator = Validator::make(['hash' => $url], [
            'hash' => ['required', 'max:255', 'url:http,https', 'unique:links,hash'],
        ]);

        if ($validator->fails()) {
            return $this->generateLink($url);
        }

        return $url;
    }
}

<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Helper;

use League\CLImate\CLImate;
use OAuth\Common\Storage\Memory;
use OAuth\OAuth1\Token\StdOAuth1Token;
use Samwilson\PhpFlickr\PhpFlickr;

class FlickrAuthHelper
{
    public function getPhpFlickr(): PhpFlickr
    {
        $apiKey = \env('FLICKR_API_KEY');
        $apiSecret = \env('FLICKR_API_SECRET');
        $accessToken = \env('FLICKR_OAUTH_ACCESS_TOKEN');
        $accessTokenSecret = \env('FLICKR_OAUTH_ACCESS_SECRET');

        if (!isset($apiKey) || !isset($apiSecret) || !isset($accessToken) || !isset($accessTokenSecret)) {
            $climate = new CLImate();
            $climate->error('Please set $apiKey, $apiSecret, $accessToken, and $accessTokenSecret in .env');
            exit(1);
        }

        // Add your access token to the storage.
        $token = new StdOAuth1Token();
        $token->setAccessToken($accessToken);
        $token->setAccessTokenSecret($accessTokenSecret);
        $storage = new Memory();
        $storage->storeAccessToken('Flickr', $token);
        // Create PhpFlickr.
        $phpFlickr = new PhpFlickr($apiKey, $apiSecret);
        // Give PhpFlickr the storage containing the access token.
        $phpFlickr->setOauthStorage($storage);

        return $phpFlickr;
    }
}

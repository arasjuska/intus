<?php

namespace App\Services\Api;

use Exception;
use Illuminate\Support\Facades\Http;

class GoogleSafeBrowsing
{
    protected string $apiKey;
    protected string $apiDomain;
    protected string $clientId;
    protected string $clientVersion;
    protected array $threatTypes;
    protected array $platformTypes;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $file = 'google-safe-browsing';

        $this->apiKey = config("$file.api_key");
        $this->apiDomain = config("$file.api_domain");
        $this->clientId = config("$file.client_id");
        $this->clientVersion = config("$file.client_version");
        $this->threatTypes = config("$file.threat_types");
        $this->platformTypes = config("$file.threat_platforms");
    }

    /**
     * @throws Exception
     */
    public function isSafeUrl(string $url): bool
    {
        $result = $this->getApiResult($url);
        if (is_array($result) and isset($result['matches'])) {
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */
    protected function getApiResult(string $url): array|string
    {
        $lookupUrl = $this->apiDomain . "/threatMatches:find?key=" . $this->apiKey;
        $lookupData = [
            'client' => [
                'clientId' => $this->clientId,
                'clientVersion' => $this->clientVersion,
            ],
            'threatInfo' => [
                'threatTypes' => $this->threatTypes,
                'platformTypes' => $this->platformTypes,
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [
                    [
                        'url' => $url,
                    ],
                ],
            ],
        ];

        $response = Http::post($lookupUrl, $lookupData);
        if ($response->failed()) {
            throw new Exception($response->json('error.message'));
        }

        return $response->json();
    }
}

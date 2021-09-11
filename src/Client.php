<?php declare(strict_types=1);
namespace ImboClient;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\HandlerStack;
use ImboClient\Exception\RequestException;
use ImboClient\Middleware\AccessToken;
use ImboClient\Middleware\Authenticate;
use ImboClient\Response\Status;

class Client
{
    private string $serverUrl;
    private string $user;
    private string $publicKey;
    private string $privateKey;
    private GuzzleHttpClient $httpClient;

    /**
     * Class constructor
     *
     * @param string $serverUrl URL to the Imbo server
     * @param string $user User for imbo
     * @param string $publicKey Public key for user
     * @param string $privateKey Private key for user
     * @param GuzzleHttpClient $httpClient Pre-configured HTTP client
     */
    public function __construct(string $serverUrl, string $user, string $publicKey, string $privateKey, GuzzleHttpClient $httpClient = null)
    {
        $this->serverUrl = $serverUrl;
        $this->user = $user;
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;

        if (null === $httpClient) {
            $handler = HandlerStack::create();
            $handler->push(new AccessToken($this->privateKey));
            $handler->push(new Authenticate($this->publicKey, $this->privateKey));
            $httpClient = new GuzzleHttpClient(['handler' => $handler]);
        }

        $this->httpClient = $httpClient;
    }

    /**
     * @throws RequestException
     */
    public function getServerStatus(): Status
    {
        try {
            $response = $this->httpClient->get($this->getUriForPath('status.json'));
        } catch (ServerException $e) {
            $response = $e->getResponse();
        } catch (BadResponseException $e) {
            throw new RequestException('Unable to request Imbo status', $e->getRequest(), $e);
        }

        return Status::fromHttpResponse($response);
    }

    private function getUriForPath(string $path): string
    {
        return rtrim($this->serverUrl, '/') . '/' . ltrim($path, '/');
    }
}

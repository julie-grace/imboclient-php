<?php declare(strict_types=1);
namespace ImboClient\Response;

use ImboClient\Utils;
use Psr\Http\Message\ResponseInterface;

class AddedImage
{
    private string $imageIdentifier;
    private int $width;
    private int $height;
    private string $extension;

    public function __construct(string $imageIdentifier, int $width, int $height, string $extension)
    {
        $this->imageIdentifier = $imageIdentifier;
        $this->width           = $width;
        $this->height          = $height;
        $this->extension       = $extension;
    }

    public static function fromHttpResponse(ResponseInterface $response): self
    {
        /** @var array{imageIdentifier:string,width:int,height:int,extension:string} */
        $body = Utils::convertResponseToArray($response);
        return new self($body['imageIdentifier'], $body['width'], $body['height'], $body['extension']);
    }

    public function getImageIdentifier(): string
    {
        return $this->imageIdentifier;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }
}

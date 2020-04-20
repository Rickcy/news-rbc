<?php


namespace app\src\api;


/**
 * Class NewsResponse
 * @package app\src\api
 */
class NewsDto implements IResponse, \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $urlToImage;
    /**
     * @var string
     */
    private $published_at;

    /**
     * @var string
     */
    private $content;

    /**
     * NewsResponse constructor.
     * @param string $author
     * @param string $source
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $urlToImage
     * @param string $published_at
     * @param string|null $content
     * @param int|null $id
     */
    public function __construct(string $author, string $source, string $title, string $description, string $url, string $urlToImage, string $published_at, string $content = null, int $id = null)
    {
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
        $this->source = trim($source, '/');
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->urlToImage = $urlToImage;
        $this->published_at = $published_at;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }


    /**
     * @return mixed
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }


    /**
     * @return mixed
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getUrlToImage(): string
    {
        return $this->urlToImage;
    }

    /**
     * @return mixed
     */
    public function getPublishedAt(): string
    {
        return $this->published_at;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [
            'source' => $this->source,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'urlToImage' => $this->urlToImage,
            'published_at' => $this->published_at,
        ];

        if ($this->id) {
            $result['id'] = $this->id;
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
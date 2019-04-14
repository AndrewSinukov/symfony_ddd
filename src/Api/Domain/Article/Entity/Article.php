<?php

namespace App\Api\Domain\Article\Entity;

use App\Api\Domain\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Sluggable\Util as Sluggable;

class Article
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var User
     */
    protected $author;

    /**
     * @var Tag|ArrayCollection
     */
    protected $tags;

    /**
     * @var ArrayCollection
     */
    protected $images;

    /**
     * @var ArrayCollection|User
     */
    protected $contributors;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return Article
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Article
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return Article
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Tag|ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag|ArrayCollection $tags
     *
     * @return Article
     */
    public function setTags($tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    /**
     * @param $name
     */
    public function addTagFromName($name): void
    {
        $tag = new Tag();
        $slug = Sluggable\Urlizer::urlize($name);
        $tag->setTitle($name);
        $tag->setSlug($slug);

        $this->tags->add($tag);
    }

    /**
     * @return ArrayCollection
     */
    public function getImages(): ArrayCollection
    {
        return $this->images;
    }

    /**
     * @param ArrayCollection $images
     *
     * @return Article
     */
    public function setImages(ArrayCollection $images): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return User|ArrayCollection
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * @param User|ArrayCollection $contributors
     *
     * @return Article
     */
    public function setContributors($contributors): self
    {
        $this->contributors = $contributors;

        return $this;
    }

    /**
     * @param User $contributor
     */
    public function addContributor(User $contributor): void
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors->add($contributor);
        }
    }
}

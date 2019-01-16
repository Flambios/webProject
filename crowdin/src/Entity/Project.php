<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\lang", inversedBy="lang")
     * @ORM\JoinColumn(nullable=true)
     */
    private $originalLang;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\lang", cascade={"persist"})
     */
    private $langs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="project")
     */
    private $sources;

    public function __construct()
    {
        $this->langs = new ArrayCollection();
        $this->sources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOriginalLang(): ?Lang
    {
        return $this->originalLang;
    }

    public function setOriginalLang(?Lang $originalLang): self
    {
        $this->originalLang = $originalLang;

        return $this;
    }

    /**
     * @return Collection|Lang[]
     */
    public function getLangs(): Collection
    {
        return $this->langs;
    }

    public function addLang(Lang $lang): self
    {
        if (!$this->langs->contains($lang)) {
            $this->langs[] = $lang;
        }

        return $this;
    }

    public function removeLang(Lang $lang): self
    {
        if ($this->langs->contains($lang)) {
            $this->langs->removeElement($lang);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    public function addSource(self $source): self
    {
        if (!$this->sources->contains($source)) {
            $this->sources[] = $source;
            $source->setProject($this);
        }

        return $this;
    }

    public function removeSource(self $source): self
    {
        if ($this->sources->contains($source)) {
            $this->sources->removeElement($source);
            // set the owning side to null (unless already changed)
            if ($source->getProject() === $this) {
                $source->setProject(null);
            }
        }

        return $this;
    }
}

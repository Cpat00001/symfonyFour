<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 //* @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Product
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     * @var string
     */
    private $image;
    /**
     * @Vich\UploadableField(mapping="products", fileNameProperty="image", size="imageSize")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="basket")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    //  /**
    //  * @ORM\Column(type="datetime")
    //  * @var \DateTime
    //  */
    // private $updatedAt;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    // added for images
    /**
     * Undocumented function
     *
     * @param File|null $imageFile
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        // if ($imageFile) {
        //     // if 'updatedAt' is not defined in your entity, use another property
        //     $this->updatedAt = new \DateTime('now');
        // }
    }
    /**
     *
     * @return File|null 
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile; 
    }
    /**
     * Undocumented function
     *
     * @param string|null $image
     * @return this
     */
    public function setImage(?string $image):self
    {
        $this->image = $image;
        return $this;
    }
    /**
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addBasket($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeBasket($this);
        }

        return $this;
    }
}

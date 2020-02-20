<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     collectionOperations={"get"={
 *      "normalization_context"={"groups"={"courses:read", "courses:item:get"}}
 *     }, "post"},
 *     itemOperations={
 *      "get"={
 *          "normalization_context"={"groups"={"courses:read", "courses:item:get"}}
 *      },
 *      "put",
 *      "delete"
 *     },
 *     normalizationContext={"groups"={"courses:read"}},
 *     denormalizationContext={"groups"={"courses:write"}},
 *
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"courses:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"courses:read", "courses:write", "user:read"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *  min=5,
     *  max=255,
     *  minMessage="Course name should be more than 5 Characters",
     *  maxMessage="Course name should not be more than 255 Characters"
     * )
     * @ApiFilter(SearchFilter::class, strategy="ipartial")
     * @ApiProperty(iri="http://schema.org/name")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"courses:read", "courses:write"})
     * @MaxDepth(10)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="courses")
     * @Groups({"courses:read", "courses:write"})
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Student", mappedBy="course")
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addCourse($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeCourse($this);
        }

        return $this;
    }
}

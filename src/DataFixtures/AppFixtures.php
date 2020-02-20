<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Course;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var \Faker\Factory
     */
    private $faker;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
       $this->loadUser($manager);
       $this->loadStudent($manager);
       $this->loadAuthor($manager);
       $this->loadCourse($manager);
    }

    public function loadCourse(ObjectManager $manager){

        $user = $this->getReference('user');
        for($i=0; $i<50; $i++){
            $student = $this->getReference('student_' . rand(1, 10));
            $author = $this->getReference('author_'. rand(1, 10));
            $course = new Course();
            $course->setName('Learn about ' . $this->faker->company);
            $course->setAuthor($author);
            $course->setOwner($user);
            $course->addStudent($student);
            $this->setReference('course_' . $i, $course);
            $manager->persist($course);
        }
        $manager->flush();

    }
    public function loadStudent(ObjectManager $manager){
        $user = $this->getReference('user');
        for($i=1; $i<=10; $i++) {
            $student = new Student();
            $student->setFirstName($this->faker->firstName());
            $student->setLastName($this->faker->lastName());
            $student->setOwner($user);
            $this->addReference('student_' . $i, $student);
            $manager->persist($student);
        }
        $manager->flush();
    }
    public function loadAuthor(ObjectManager $manager){
        $user = $this->getReference('user');
        for($i=1; $i<=10; $i++) {
            $author = new Author();
            $author->setName($this->faker->name());
            $author->setOwner($user);
            $this->addReference('author_' . $i, $author);
            $manager->persist($author);
        }
        $manager->flush();
    }

    public function loadUser(ObjectManager $manager){
        $user = new User();

        $user->setUsername('Admin');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Admin123'
        ));
        $user->setEmail('admin@edrisa.com');
        $user->setStatus(true);
        $this->addReference('user', $user);

        $manager->persist($user);
        $manager->flush();
    }
}

<?php
// Lớp trừu tượng Person
abstract class Person {
    protected $name;

    // Phương thức trừu tượng
    abstract public function introduce();
}

// Lớp trừu tượng Animal
abstract class Animal extends Person {
    // Phương thức trừu tượng
    abstract public function makeSound();
}

// Lớp con kế thừa từ lớp trừu tượng Animal
class Dog extends Animal {
    // Phương thức khởi tạo
    public function __construct($name) {
        $this->name = $name;
    }

    // Phương thức override từ lớp cha
    public function makeSound() {
        return "Woof!";
    }

    // Phương thức override từ lớp cha
    public function introduce() {
        return "I am a dog named {$this->name}.";
    }
}

// Lớp con khác kế thừa từ lớp trừu tượng Animal
class Cat extends Animal {
    // Phương thức khởi tạo
    public function __construct($name) {
        $this->name = $name;
    }

    // Phương thức override từ lớp cha
    public function makeSound() {
        return "Meow!";
    }

    // Phương thức override từ lớp cha
    public function introduce() {
        return "I am a cat named {$this->name}.";
    }
}

// Lớp Sinh viên
class Student extends Person {
    private $studentId;

    // Phương thức khởi tạo
    public function __construct($name, $studentId) {
        $this->name = $name;
        $this->studentId = $studentId;
    }

    // Phương thức override từ lớp cha
    public function introduce() {
        return "I am a student named {$this->name} with ID {$this->studentId}.";
    }
}

// Lớp sử dụng tính chất đóng gói và đa hình
class Zoo {
    private $people = [];

    // Phương thức thêm người vào zoo
    public function addPerson(Person $person) {
        $this->people[] = $person;
    }

    // Phương thức hiển thị giới thiệu của tất cả người trong zoo
    public function introduceAll() {
        foreach ($this->people as $person) {
            echo $person->introduce() . "<br>";
        }
    }
}

// Tạo đối tượng Dog, Cat và Student
$dog = new Dog("Buddy");
$cat = new Cat("Whiskers");
$student = new Student("John Doe", "S123456");

// Tạo đối tượng Zoo
$zoo = new Zoo();

// Thêm người vào zoo
$zoo->addPerson($dog);
$zoo->addPerson($cat);
$zoo->addPerson($student);

// Hiển thị giới thiệu của tất cả người trong zoo
$zoo->introduceAll();
?>

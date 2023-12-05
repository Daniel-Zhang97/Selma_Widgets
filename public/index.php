<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
//$faker = Faker\Factory::create();
//$pdo = new PDO('mysql:dbname=selma_db;host=localhost;port=3306', 'root', null);

//    Seeding students table
//    for($i = 1; $i <= 200; $i++) {
//        $student_first_name = $faker->firstName;
//        $student_surname = $faker->lastName;
//        $student_bank_account = $faker->regexify('[0-9]{16}');
//
//        $stmt = $pdo->prepare("INSERT INTO student (student_first_name, student_surname, student_bank_account) VALUES (?, ?, ?)");
//        $stmt->execute([$student_first_name, $student_surname, $student_bank_account]);
//    }
//
//    Seeding enrolment table
//
//    for ($i = 1; $i <= 200; $i++) {
//        $date = $faker->dateTimeBetween('-8 years', '+0 year');
//        $randStudent = rand(0, 199);
//        $getId = $pdo->prepare('SELECT student_id FROM student LIMIT 1 OFFSET ?');
//        $getId->bindParam(1, $randStudent, PDO::PARAM_INT);
//        $getId->execute();
//        $result = $getId->fetch(PDO::FETCH_ASSOC);
//        $studentId = $result['student_id'];
//
//
//        $stmt = $pdo->prepare("INSERT INTO enrolment (date, student_id) VALUES (? , ?)");
//        $stmt->execute([$date->format('Y-m-d H-i-s'), $studentId]);
//
//    }
//
//
//    seeding invoice_header table
//
//for ($i = 0; $i < 200; $i++) {
//    $date = $faker->dateTimeBetween('-8 years', '+2 year');
//    $getId = $pdo->prepare('SELECT * FROM enrolment LIMIT 1 OFFSET ?');
//    $getId->bindParam(1, $i, PDO::PARAM_INT);
//    $getId->execute();
//    $result = $getId->fetch(PDO::FETCH_ASSOC);
//    $studentId = $result['student_id'];
//    $enrolment_number = $result['enrolment_number'];
//    $amountDue = rand(1000, 5000);
//
//    $enrolmentDate = new DateTime($result['date']);
//    $dateDifference = $enrolmentDate->diff($date);
//    $date->add($dateDifference);
//
//    $stmt = $pdo->prepare("INSERT INTO invoice_header (student_id, due_date, enrolment_number, amount_due) VALUES (?, ?, ?, ?)");
//    $stmt->execute([$studentId, $date->format('Y-m-d H-i-s'), $enrolment_number, $amountDue]);
//
//}
//
//
////      Seeding invoice_line table
//
//
//for ($i = 0; $i < 400; $i++) {
//    $enrolmentSelector = rand(0, 399);
//
//    $getId = $pdo->prepare('SELECT * FROM invoice_header LIMIT 1 OFFSET ?');
//    $getId->bindParam(1, $enrolmentSelector, PDO::PARAM_INT);
//    $getId->execute();
//    $result = $getId->fetch(PDO::FETCH_ASSOC);
//
//    // Get the associated enrolment date
//    $getEnrolment = $pdo->prepare('SELECT date FROM enrolment WHERE enrolment_number = ?');
//    $getEnrolment->bindParam(1, $result['enrolment_number']);
//    $getEnrolment->execute();
//    $enrolmentResult = $getEnrolment->fetch(PDO::FETCH_ASSOC);
//
//    // Calculate payment date based on enrolment date
//    $enrolmentDate = new DateTime($enrolmentResult['date']);
//    $payment_date = $faker->dateTimeBetween($enrolmentDate, 'now');
//
//    $invoice_header_number = $result['invoice_header_number'];
//    $amount = rand(1000, 5000);
//    $studentId = $result['student_id'];
//
//    $stmt = $pdo->prepare("INSERT INTO invoice_line (invoice_header_number, amount, student_id, payment_date) VALUES (?, ?, ?, ?)");
//    $stmt->execute([$invoice_header_number, $amount, $studentId, $payment_date->format('Y-m-d H-i-s')]);
//}
//
//
//$results = $pdo->query('SELECT * FROM invoice_line');
//$rows = $results->fetchAll();
//var_dump($rows);
//die;

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

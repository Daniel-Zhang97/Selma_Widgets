<?php

//    Seeding students table
//    for ($i = 1; $i <= 200; $i++) {
//        $student_first_name = $faker->firstName;
//        $student_surname = $faker->lastName;
//        $student_bank_account = $faker->regexify('[0-9]{16}');
//
//        $stmt = $pdo->prepare("INSERT INTO student (student_first_name, student_surname, student_bank_account) VALUES (?, ?, ?)");
//        $stmt->execute([$student_first_name, $student_surname, $student_bank_account]);
//
//    }
//    Seeding enrolment table
//    for ($i = 1; $i <= 200; $i++) {
//        $date = $faker->dateTimeBetween('-20 years', '+1 year');
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
////    seeding invoice_header table
//    for ($i = 0; $i < 200; $i++) {
//        $date = $faker->dateTimeBetween('-3 years', '+1 year');
//        $getId = $pdo->prepare('SELECT * FROM enrolment LIMIT 1 OFFSET ?');
//        $getId->bindParam(1, $i, PDO::PARAM_INT);
//        $getId->execute();
//        $result = $getId->fetch(PDO::FETCH_ASSOC);
//        $studentId = $result['student_id'];
//        $enrolment_number = $result['enrolment_number'];
//
//
//        $stmt = $pdo->prepare("INSERT INTO invoice_header (student_id, date, enrolment_number) VALUES (? , ? , ?)");
//        $stmt->execute([$studentId, $date->format('Y-m-d H-i-s'), $enrolment_number]);
//
//    }
//
////      Seeding invoice_line table
//    for ($i = 0; $i < 400; $i++) {
//        $studentSelector = rand(0, 199);
//        $due_date = $faker->dateTimeBetween('-1 years', '+1 year');
//        $getId = $pdo->prepare('SELECT * FROM invoice_header LIMIT 1 OFFSET ?');
//        $getId->bindParam(1, $studentSelector, PDO::PARAM_INT);
//        $getId->execute();
//        $result = $getId->fetch(PDO::FETCH_ASSOC);
//
//        $invoice_header_number = $result['invoice_header_number'];
//        $is_paid = rand(0, 1);
//        $amount = rand(1000, 5000);
//        $studentId = $result['student_id'];
//
//        $stmt = $pdo->prepare("INSERT INTO invoice_line (invoice_header_number, is_paid, amount, due_date, student_id) VALUES (?, ?, ?, ?, ?)");
//        $stmt->execute([$invoice_header_number, $is_paid, $amount, $due_date->format('Y-m-d'), $studentId]);
//
//    }



//    $results = $pdo->query('SELECT * FROM invoice_line');
//    $rows = $results->fetchAll();
//    var_dump($rows);
//    die;

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

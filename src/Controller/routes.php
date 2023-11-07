<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;
use PDO;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\Error;
use const http\Client\Curl\POSTREDIR_301;

class routes extends AbstractController
{

    private $pdo;
    public function __construct() {
         $this->pdo = new PDO('mysql:dbname=selma_db;host=localhost;port=3306', 'root', null);
    }

    #[Route('/request', methods: ['GET', 'POST'])]
    public function requestHandler(Request $request = null): Response
    {
            if ($request !== null) {
                $filterOptionsJSON = $request->getContent();
                $decodedOptions = json_decode($filterOptionsJSON, true);
                if($decodedOptions && $decodedOptions['generateReport'] && $decodedOptions['generateReport'] === true) {
                    $res = $this->generateRevenueStatement();
                } else if (!$decodedOptions || !$decodedOptions['groupBy']) {
                    return new Response('no');
                } else {
                    $res = $this->getInvoiceLines($decodedOptions);

                    if ($decodedOptions['groupBy'] == 'Yearly') {
                        ksort($res);
                    } else {

                        $monthsOrder = [
                            'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6,
                            'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12
                        ];
                        $quartersOrder = [
                            'Q1' => 1, 'Q2' => 2, 'Q3' => 3, 'Q4' => 4
                        ];

                        uksort($res, function($a, $b) use ($quartersOrder, $monthsOrder, $decodedOptions) {
                            $yearA = substr($a, 0, 4);
                            $yearB = substr($b, 0, 4);

                            if ($yearA != $yearB) {
                                return $yearA - $yearB;
                            } else {
                                $groupA = substr($a, 5);
                                $groupB = substr($b, 5);
                                if ($decodedOptions['groupBy'] === 'Quarterly') {
                                    return $quartersOrder[$groupA] - $quartersOrder[$groupB];
                                } else {
                                    $monthA = $groupA;
                                    $monthB = $groupB;
                                    return $monthsOrder[$monthA] - $monthsOrder[$monthB];
                                }
                            }
                        });
                    }
                }
            }

        return new Response(json_encode($res));
    }

    private function getInvoiceLines($decodedOptions = null): array
    {
        $res = [];
        if($decodedOptions !== null) {

            $startDate = $decodedOptions['startDate'];
            $endDate = $decodedOptions['endDate'];

            $stmt = $this->pdo->prepare('SELECT * FROM invoice_header WHERE due_date >= :start_date AND due_date <= :end_date');
            $stmt->bindParam(':start_date', $startDate, \PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $endDate, \PDO::PARAM_STR);
            $stmt->execute();
            $invoice_header = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $res = $this->creatBarChart($invoice_header, $decodedOptions);
        }

        return $res;
    }

    private function creatBarChart($invoice_header, $options = null) {
        $currentDate = date('Y-m-d');
        $graphData = [];

        foreach ($invoice_header as $line) {
            $groupKey = $this->getGroupKey($line['due_date'], $options['groupBy']);

            $getInvoiceLines = $this->pdo->prepare('SELECT * FROM invoice_line WHERE invoice_header_number = ?');
            $getInvoiceLines->bindParam(1, $line['invoice_header_number']);
            $getInvoiceLines->execute();
            $invoice_lines = $getInvoiceLines->fetchAll(PDO::FETCH_ASSOC);
            $totalPaid = 0;

            foreach ($invoice_lines as $invoice_line) {
                $totalPaid += $invoice_line['amount'];
            }

            if (!isset($graphData[$groupKey])) {
                $graphData[$groupKey] = [
                    'Collected' => 0,
                    'Uncollected' => 0,
                    'Overdue' => 0,
                    'Overpaid' => 0,
                ];
            }

            if ($line['amount_due'] <= $totalPaid && $options['Collected']) {
                $graphData[$groupKey]['Collected'] += $line['amount_due'];
                if($options['Overpaid']){
                    $graphData[$groupKey]['Overpaid'] += $totalPaid - $line['amount_due'];
                }
            } elseif ($line['due_date'] < $currentDate && $options['Overdue']) {
                $graphData[$groupKey]['Collected'] += $totalPaid;
                $graphData[$groupKey]['Overdue'] += $line['amount_due'] - $totalPaid;
            } elseif ($line['due_date'] > $currentDate && $options['Uncollected']) {
                $graphData[$groupKey]['Collected'] += $totalPaid;
                $graphData[$groupKey]['Uncollected'] += $line['amount_due'] - $totalPaid;
            }
        }

        return $graphData;
    }

    private function getGroupKey($date, $groupBy) {
        if ($groupBy === 'Yearly') {
            return substr($date, 0, 4);
        } elseif ($groupBy === 'Quarterly') {
            $quarter = ceil(date('n', strtotime($date)) / 3);
            $year = substr($date, 0, 4);
            return $year . ' Q' . $quarter;
        } elseif ($groupBy === 'Monthly') {
            $year = substr($date, 0, 4);
            $month = date('M', strtotime($date));
            return $year . ' ' . $month;
        }
    }

    private function generateRevenueStatement($decodedOptions = null) {

        return 'working';
    }

}

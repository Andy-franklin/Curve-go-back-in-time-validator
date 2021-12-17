<?php

class CsvInfo {
    const CURVE_DESCRIPTION_PREFIX = 'CRV*';
    const DATE_COLUMN_OFFSET = 1;
    const DESCRIPTION_COLUMN_OFFSET = 4;
    const DEBIT_COLUMN_OFFSET = 5;
    const CREDIT_COLUMN_OFFSET = 6;
}

$files = array_diff(scandir('./input'), ['.', '..']);

foreach ($files as $file) {
    processFile($file);
}

function processFile($file)
{
    echo $file . "\n";

    $rows = [];
    if (($handle = fopen("./input/$file", 'rb')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $rows[] = $data;
        }
        fclose($handle);
    }

    $curveDebits = [];
    $curveCredits = [];
    foreach ($rows as $row) {
        if (strpos($row[CsvInfo::DESCRIPTION_COLUMN_OFFSET], CsvInfo::CURVE_DESCRIPTION_PREFIX) === 0) {
            if ($row[CsvInfo::CREDIT_COLUMN_OFFSET] !== '') {
                $curveCredits[] = $row;
            } elseif ($row[CsvInfo::DEBIT_COLUMN_OFFSET] !== '') {
                $curveDebits[] = $row;
            }
        }
    }

    $settled = $unsettled = [];
    echo 'Curve Debits: ' . count($curveDebits) . "\n";
    echo 'Curve Credits: ' . count($curveCredits) . "\n";
    foreach ($curveDebits as $curveDebit) {
        foreach ($curveCredits as $creditIndex => $curveCredit) {
            if ($curveCredit[CsvInfo::CREDIT_COLUMN_OFFSET] === $curveDebit[CsvInfo::DEBIT_COLUMN_OFFSET]) {
                $settled[] = ['debit' => $curveDebit, 'credit' => $curveCredit];
                unset($curveCredits[$creditIndex]);
                continue 2;
            }
        }

        $unsettled[] = $curveDebit;
    }

    $outputName = './output/' . $file . '-Processed.csv';
    $output = fopen($outputName, 'wb');

    echo 'Unsettled: ' . count($unsettled) . "\n";
    echo 'Settled: ' . count($settled) . "\n";

    if (count($unsettled) > 0) {
        fputcsv($output, ['UNSETTLED: ' . count($unsettled)]);
        fputcsv($output, $rows[0]);
        foreach ($unsettled as $unsettledTransaction) {
            fputcsv($output, $unsettledTransaction);
        }
    }

    if (count($settled) > 0) {
        fputcsv($output, ['SETTLED: ' . count($settled)]);
        fputcsv($output, $rows[0]);
        foreach ($settled as $settledTransaction) {
            fputcsv($output, $settledTransaction['debit']);
        }
    }
    fclose($output);
}

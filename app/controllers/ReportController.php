<?php

require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController
{
    private Transaction $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new Transaction();
    }

    public function index(): void {
        $transactions = [];
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
    
        if ($startDate && $endDate) {
            $transactions = $this->transactionModel->getByDateRange($startDate, $endDate);

            $totalIncome = 0;
            $totalExpense = 0;

            foreach ($transactions as $t) {
                if ($t['category_type'] === 'receita') {
                    $totalIncome += $t['amount'];
                } elseif ($t['category_type'] === 'despesa') {
                    $totalExpense += $t['amount'];
                }
            }

            $balance = $totalIncome - $totalExpense;

        }
    
        include __DIR__ . '/../views/reports/index.php';
    }
    
    public function exportPdf(): void {
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $transactions = $this->transactionModel->getByDateRange($startDate, $endDate);
    
        $totalIncome = 0;
        $totalExpense = 0;
        
        foreach ($transactions as $t) {
            if ($t['category_type'] === 'receita') {
                $totalIncome += $t['amount'];
            } elseif ($t['category_type'] === 'despesa') {
                $totalExpense += $t['amount'];
            }
        }
        
        $balance = $totalIncome - $totalExpense;
        

        ob_start();
        include __DIR__ . '/../views/reports/pdf_template.php';
        $html = ob_get_clean();
    
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("relatorio.pdf", ["Attachment" => false]);
    }
    
    public function exportExcel(): void {
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
    
        $transactions = $this->transactionModel->getByDateRange($startDate, $endDate);
    
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Relatório');
    
        // Cabeçalho
        $sheet->fromArray([
            'ID', 'Descrição', 'Categoria', 'Tipo', 'Valor (R$)', 'Data', 'Usuário', 'Email'
        ], null, 'A1');
    
        // Conteúdo
        $row = 2;
        $totalIncome = 0;
        $totalExpense = 0;
    
        foreach ($transactions as $t) {
            $amount = floatval($t['amount']);
            $sheet->setCellValue("A{$row}", $t['id']);
            $sheet->setCellValue("B{$row}", $t['description']);
            $sheet->setCellValue("C{$row}", $t['category_name']);
            $sheet->setCellValue("D{$row}", $t['category_type']);
            $sheet->setCellValue("E{$row}", $amount);
            $sheet->setCellValue("F{$row}", $t['date']);
            $sheet->setCellValue("G{$row}", $t['user_name']);
            $sheet->setCellValue("H{$row}", $t['user_email']);
    
            if ($t['category_type'] === 'receita') {
                $totalIncome += $amount;
            } elseif ($t['category_type'] === 'despesa') {
                $totalExpense += $amount;
            }
    
            $row++;
        }
    
        $balance = $totalIncome - $totalExpense;
    
        // Adiciona totais
        $sheet->setCellValue("D{$row}", 'Total Entradas:');
        $sheet->setCellValue("E{$row}", $totalIncome);
        $row++;
    
        $sheet->setCellValue("D{$row}", 'Total Saídas:');
        $sheet->setCellValue("E{$row}", $totalExpense);
        $row++;
    
        $sheet->setCellValue("D{$row}", 'Saldo Final:');
        $sheet->setCellValue("E{$row}", $balance);
    
        // Define headers
        if (ob_get_length()) ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="relatorio_lancamentos.xlsx"');
        header('Cache-Control: max-age=0');
    
        // Salva e envia para o navegador
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    
}

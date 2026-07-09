<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SiswaTemplateExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    /**
     * Return an empty array — just the headings (template).
     */
    public function array(): array
    {
        return [
            // Baris contoh (bisa dikomentari atau dikasih warna)
            ['', 'Contoh: Ahmad Fauzi', '7', 'A', 'Laki-laki'],
            ['', 'Contoh: Siti Aisyah', '8', 'B', 'Perempuan'],
        ];
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Lengkap',
            'Tingkat',
            'Rombel',
            'Jenis Kelamin',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Style untuk header row
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'], // Indigo
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style untuk baris contoh
        if ($highestRow >= 2) {
            $sheet->getStyle('A2:' . $highestColumn . $highestRow)->applyFromArray([
                'font' => [
                    'italic' => true,
                    'color' => ['rgb' => '6B7280'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'],
                ],
            ]);
        }

        // Border untuk semua cell
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Lebar kolom
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(18);

        // Tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(35);

        return [];
    }

    public function title(): string
    {
        return 'Template Siswa';
    }
}

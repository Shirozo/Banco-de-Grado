<?php

namespace App\Exports;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class GradeExport implements WithHeadings, WithDrawings, WithEvents
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function headings(): array
    {
        return [
            "First Sem",
            "Second Sem",
            "Average",
        ];
    }

    public function drawings()
    {
        $left = new Drawing;
        $left->setPath(public_path('images/logo.jpg'));
        $left->setHeight(90);
        $left->setWidth(5.02 * 96);
        $left->setCoordinates('A1');

        $right = new Drawing;
        $right->setPath(public_path('images/bp.png'));
        $right->setHeight(80);
        $right->setHeight(1.53 * 96);
        $right->setWidth(1.34 * 96);
        $right->setCoordinates('I1');

        return [$left, $right];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getColumnDimension("A")->setWidth(4);

                $subject = Subject::find($this->id);
                $sheet->mergeCells('A3:J3');
                $sheet->setCellValue('A3', 'REPORT OF GRADES');
                $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(14)->setName("Arial");
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getRowDimension(1)->setRowHeight(30);

                $sheet->mergeCells('A4:J4');
                if ($subject->semester == 1) {
                    $sem = "First Semester";
                } else {
                    $sem = "Second Semester";
                }
                $sheet->setCellValue('A4', $sem . ', School Year ' . $subject->school_year);
                $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(12)->setName("Arial");
                $sheet->getStyle('A4')->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->getRowDimension(1)->setRowHeight(30);

                $sheet->setCellValue('B5', 'Course No.: ');
                $sheet->getStyle('B5')->getFont()->setBold(true)->setSize(12)->setName("Arial Narrow");
                $sheet->setCellValue('B6', 'Descriptive Title: ');
                $sheet->getStyle('B6')->getFont()->setBold(true)->setSize(12)->setName("Arial Narrow");
                $sheet->setCellValue('B7', 'Course and Year: ');
                $sheet->getStyle('B7')->getFont()->setBold(true)->setSize(12)->setName("Arial Narrow");
                $sheet->setCellValue('B8', 'Schedule of Classes: ');
                $sheet->getStyle('B8')->getFont()->setBold(true)->setSize(12)->setName("Arial Narrow");
                $sheet->setCellValue('B9', 'Number of Units: ');
                $sheet->getStyle('B9')->getFont()->setBold(true)->setSize(12)->setName("Arial Narrow");
                $sheet->setCellValue('B10', 'Room: ');
                $sheet->getStyle('B10')->getFont()->setBold(true)->setSize(12)->setName("Arial Narrow");


                $sheet->setCellValue('F5', 'Grading System');
                $sheet->getStyle('F5')->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow");
                $sheet->setCellValue('F6', 'Actual Rating');
                $sheet->getStyle('F6')->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow")->setUnderline(true);
                $sheet->setCellValue('G6', 'Equivalent Rating');
                $sheet->getStyle('G6')->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow")->setUnderline(true);
                $sheet->setCellValue('H6', 'Adjectival Rating');
                $sheet->getStyle('H6')->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow")->setUnderline(true);

                $sheet->setCellValue('F7', '90% - 100%');
                $sheet->setCellValue('F8', '85% - 89%');
                $sheet->setCellValue('F9', '80% - 84%');
                $sheet->setCellValue('F10', '75% - 79%');
                $sheet->setCellValue('F11', '70% - 74%');
                $sheet->setCellValue('F12', '65% - 69%');
                $sheet->setCellValue('F13', 'Below 65%');
                $sheet->setCellValue('F14', 'INC');
                $sheet->setCellValue('F15', 'Dr');
                $sheet->setCellValue('F16', 'WP');
                foreach (range(7, 16) as $row) {
                    $sheet->getRowDimension($row)->setRowHeight(15);
                }
                $sheet->getStyle('F7:F16')->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow")->setUnderline(false);

                $sheet->setCellValue('G7', '1.0');
                $sheet->setCellValue('G8', '1.1 - 1.5');
                $sheet->setCellValue('G9', '1.6 - 2.0');
                $sheet->setCellValue('G10', '2.1 - 2.5');
                $sheet->setCellValue('G11', '2.6 - 3.0');
                $sheet->setCellValue('G12', '3.1 - 3.5');
                $sheet->setCellValue('G13', '3.6 - 5.0');
                $sheet->setCellValue('G14', 'INC');
                $sheet->setCellValue('G15', 'Dr');
                $sheet->setCellValue('G16', 'WP');
                $sheet->setCellValue('G17', 'IP');
                $sheet->getStyle('G7:G17')->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow")->setUnderline(false);

                $sheet->setCellValue('H7', 'Outstanding');
                $sheet->setCellValue('H8', 'Excellent');
                $sheet->setCellValue('H9', 'Very Good');
                $sheet->setCellValue('H10', 'Good');
                $sheet->setCellValue('H11', 'Fair');
                $sheet->setCellValue('H12', 'Conditional');
                $sheet->setCellValue('H13', 'Failed');
                $sheet->setCellValue('H14', 'Incomplete');
                $sheet->setCellValue('H15', 'Dropped');
                $sheet->setCellValue('H16', 'Withdrawn w/ Permission');
                $sheet->setCellValue('H17', 'In Progress');
                $sheet->getStyle('H7:H17')->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow")->setUnderline(false);

                $sheet->setCellValue('A19', 'No.');
                $sheet->getStyle('A19')->getFont()->setBold(true)->setSize(11)->setName("Arial Narrow")->setUnderline(false);
                $sheet->mergeCells('B19:E19');
                $sheet->setCellValue('B19', 'Name of Student');
                $sheet->getStyle('B19')->getFont()->setBold(true)->setSize(11)->setName("Arial Narrow")->setUnderline(false);
                $sheet->getStyle('B19')->getAlignment()->setHorizontal('center')->setVertical('center');
                $sheet->setCellValue('F19', 'Student No.');
                $sheet->getColumnDimension("F")->setWidth(10);
                $sheet->getStyle('F19')->getFont()->setBold(true)->setSize(11)->setName("Arial Narrow")->setUnderline(false);
                $sheet->getStyle('F19')->getAlignment()->setHorizontal('center')->setVertical('center');

                $sheet->setCellValue('G19', 'Midterm');
                $sheet->getStyle('G19')->getFont()->setBold(true)->setSize(11)->setName("Arial Narrow")->setUnderline(false);
                $sheet->getStyle('G19')->getAlignment()->setHorizontal('center')->setVertical('center');

                $sheet->setCellValue('H19', 'Finals');
                $sheet->getStyle('H19')->getFont()->setBold(true)->setSize(11)->setName("Arial Narrow")->setUnderline(false);
                $sheet->getStyle('H19')->getAlignment()->setHorizontal('center')->setVertical('center');

                $sheet->setCellValue('I19', 'Average');
                $sheet->getStyle('I19')->getFont()->setBold(true)->setSize(11)->setName("Arial Narrow")->setUnderline(false);
                $sheet->getStyle('I19')->getAlignment()->setHorizontal('center')->setVertical('center');

                $sheet->setCellValue('J19', 'Remark');
                $sheet->getStyle('J19')->getFont()->setBold(true)->setSize(11)->setName("Arial Narrow")->setUnderline(false);
                $sheet->getStyle('J19')->getAlignment()->setHorizontal('center')->setVertical('center');

                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'], // Black color
                        ],
                    ],
                ];

                $sheet->getStyle('A19:J19')->applyFromArray($borderStyle);
                $grades = DB::table("grades")
                    ->select(DB::raw("
                            grades.midterm,
                            grades.final,
                            grades.id, 
                            grades.status, 
                            grades.student_id, 
                            students.name,
                            students.student_id as s_id,
                            (grades.midterm + grades.final) / 2 AS average
                        "))
                    ->join("students", "grades.student_id", "=", "students.id")
                    ->where("grades.subject_id", "=", $this->id)
                    ->get();
                $startRow = 20;

                foreach ($grades as $index => $grade) {
                    $sheet->setCellValue("A" . ($startRow), $index + 1); // Serial number
                    $sheet->setCellValue("B" . ($startRow), $grade->name); // Student name
                    $col_ro = "B" . $startRow . ":E" . $startRow;
                    $sheet->mergeCells($col_ro);

                    $sheet->setCellValue("F" . ($startRow), $grade->s_id); // Student number
                    $sheet->setCellValue("G" . ($startRow), $grade->midterm == 0 ? "N/A" : $grade->midterm); // Midterm grade
                    $sheet->setCellValue("H" . ($startRow), $grade->final == 0 ? "N/A" : $grade->final); // Final grade
                    if ($grade->midterm && $grade->midterm) {
                        if ($grade->midterm == "INC" || $grade->final == "INC" || $grade->midterm == 0 || $grade->final == 0) {
                            $sheet->setCellValue("I" . ($startRow), "INC");
                            $sheet->setCellValue("J" . ($startRow), "INC"); // Average
                        } else {
                            $sheet->setCellValue("I" . ($startRow), ($grade->midterm + $grade->final) / 2 == 0 ? "N/A" : ($grade->midterm + $grade->final) / 2); // Average
                            $av = ($grade->midterm + $grade->final) / 2;
                            if ($grade->status == "dropped") {
                                $sheet->setCellValue("J" . ($startRow), "DROPPED");
                            } else if ($av <= 3 && $av >= 1) {
                                $sheet->setCellValue("J" . ($startRow), "PASSED");
                            } else if ($av > 3 && $av <= 3.5) {
                                $sheet->setCellValue("J" . ($startRow), "CONDITIONAL");
                            } else if ($av > 3.5 && $av <= 5) {
                                $sheet->setCellValue("J" . ($startRow), "FAILED");
                            }
                        }
                    }
                    $sheet->getStyle('A' . $startRow . ":J" . $startRow)->getFont()->setBold(false)->setSize(11)->setName("Arial Narrow");
                    $sheet->getStyle('A' . $startRow . ":J" . $startRow)->getAlignment()->setHorizontal('center')->setVertical('center');
                    $sheet->getStyle('A' . $startRow . ":J" . $startRow)->applyFromArray($borderStyle);
                    $startRow++;
                }

                $startRow += 2;
                $col_ro1 = "A" . $startRow . ":C" . $startRow;
                $sheet->mergeCells($col_ro1);
                $sheet->setCellValue("A" . ($startRow), "Certified True and Correct:");
                $sheet->getStyle('A' . $startRow)->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow");

                $col_ro2 = "D" . $startRow . ":E" . $startRow;
                $sheet->mergeCells($col_ro2);
                $sheet->setCellValue("D" . ($startRow), "Checked:");
                $sheet->getStyle('D' . $startRow)->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow");

                $col_ro3 = "F" . $startRow . ":G" . $startRow;
                $sheet->mergeCells($col_ro3);
                $sheet->setCellValue("F" . ($startRow), "Noted:");
                $sheet->getStyle('F' . $startRow)->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow");

                $col_ro4 = "H" . $startRow . ":I" . $startRow;
                $sheet->mergeCells($col_ro4);
                $sheet->setCellValue("H" . ($startRow), "Receieved:");
                $sheet->getStyle('H' . $startRow)->getFont()->setBold(false)->setSize(10)->setName("Arial Narrow");

                $startRow += 2;
                $col_ro1 = "A" . $startRow . ":C" . $startRow;
                $sheet->mergeCells($col_ro1);
                $sheet->setCellValue("A" . ($startRow), Auth::user()->name);
                $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow")->setUnderline(true);

                $col_ro2 = "D" . $startRow . ":E" . $startRow;
                $sheet->mergeCells($col_ro2);
                $sheet->setCellValue("D" . ($startRow), "JESUS M. MENESES, MATCS");
                $sheet->getStyle('D' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow")->setUnderline(true);

                $col_ro3 = "F" . $startRow . ":G" . $startRow;
                $sheet->mergeCells($col_ro3);
                $sheet->setCellValue("F" . ($startRow), "JEFFREY A. CO, Ph.D.");
                $sheet->getStyle('F' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow")->setUnderline(true);

                $col_ro4 = "H" . $startRow . ":I" . $startRow;
                $sheet->mergeCells($col_ro4);
                $sheet->setCellValue("H" . ($startRow), "LIEZL L. DOCENA");
                $sheet->getStyle('H' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow")->setUnderline(true);
                $sheet->getStyle('A' . $startRow . ":J" . $startRow)->getAlignment()->setHorizontal('center')->setVertical('center');

                $startRow += 1;
                $col_ro1 = "A" . $startRow . ":C" . $startRow;
                $sheet->mergeCells($col_ro1);
                $sheet->setCellValue("A" . ($startRow), "Instructor");
                $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow");

                $col_ro2 = "D" . $startRow . ":E" . $startRow;
                $sheet->mergeCells($col_ro2);
                $sheet->setCellValue("D" . ($startRow), "Department Head ");
                $sheet->getStyle('D' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow");

                $col_ro3 = "F" . $startRow . ":G" . $startRow;
                $sheet->mergeCells($col_ro3);
                $sheet->setCellValue("F" . ($startRow), "College Dean");
                $sheet->getStyle('F' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow");

                $col_ro4 = "H" . $startRow . ":I" . $startRow;
                $sheet->mergeCells($col_ro4);
                $sheet->setCellValue("H" . ($startRow), "University Registrar");
                $sheet->getStyle('H' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow");
                $sheet->getStyle('A' . $startRow . ":J" . $startRow)->getAlignment()->setHorizontal('center')->setVertical('center');

                $startRow += 5;
                $col_ro5 = "A" . $startRow . ":D" . $startRow;
                $sheet->mergeCells($col_ro5);
                $sheet->setCellValue("A" . ($startRow), "                                                                           ");
                $sheet->getStyle('A' . $startRow)->getFont()->setBold(true)->setSize(10)->setName("Arial Narrow")->setUnderline(true);

                $startRow += 1;
                $col_ro6 = "A" . $startRow . ":D" . $startRow;
                $sheet->mergeCells($col_ro6);
                $sheet->setCellValue("A" . ($startRow), "ESSU-ACAD-712.b | Version 5");
                $sheet->getStyle('A' . $startRow)->getFont()->setBold(false)->setSize(10.5)->setName("Arial");

                $startRow += 1;
                $col_ro7 = "A" . $startRow . ":D" . $startRow;
                $sheet->mergeCells($col_ro7);
                $sheet->setCellValue("A" . ($startRow), "Effectivity Date: March 15, 2024");
                $sheet->getStyle('A' . $startRow)->getFont()->setBold(false)->setSize(10.5)->setName("Arial");


                $sheet->getRowDimension(1)->setRowHeight(100);

                $sheet->getPageSetup()
                    ->setPaperSize(PageSetup::PAPERSIZE_A4);
            },
        ];
    }
}

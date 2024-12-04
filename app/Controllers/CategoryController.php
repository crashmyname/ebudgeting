<?php

namespace App\Controllers;
use App\Models\Category;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Support\BaseController;
use Support\DataTables;
use Support\Date;
use Support\Request;
use Support\Response;
use Support\Session;
use Support\UUID;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class CategoryController extends BaseController
{
    // Controller logic here
    public function getCategory(Request $request)
    {
        if (Request::isAjax()) {
            $category = Category::query()->select('uuid', 'code_category', 'category', 'group_category', 'sub', 'validity', 'category_id')->where('deleted_at', '=', null)->orderBy('category_id', 'asc')->get();
            return DataTables::of($category)->make(true);
        }
    }

    public function index()
    {
        $title = 'Category';
        $user = User::query()
            ->leftJoin('menu_access', 'menu_access.uid', '=', 'users.uid')
            ->where('menu_access.uid', '=', Session::user()->uid)
            ->where('menu_access.menu_id', '=', 2)
            ->where('menu_access.can_view', '=', 1)
            ->first();

        if (!$user) {
            View::error('errors/403');
            return;
        }
        return view('category/category', ['title' => $title], 'layout/app');
    }

    public function importExcel(Request $request)
    {
        if (!$request->file('file')) {
            echo 'File tidak ada';
            return;
        }
        $filepath = $request->file('file');
        try {
            $spreadsheet = IOFactory::load($request->getPath('file'));
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);
            array_shift($data);
            foreach ($data as $row) {
                $category = Category::query()
                    ->where('code_category', '=', trim($row['B']))
                    ->where('category', '=', trim($row['C']))
                    ->first();
                $item = [
                    'uuid' => UUID::generateUuid(),
                    'code_category' => $row['B'],
                    'category' => $row['C'],
                    'group_category' => $row['D'],
                    'sub' => $row['E'],
                    'validity' => 1,
                ];
                $item = Category::create($item);
            }
            return Response::json(['status' => 200]);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            echo 'Terjadi kesalahan saat membaca file: ' . $e->getMessage();
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            // Buat instance Spreadsheet baru
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set Style untuk Header
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'name' => 'Arial',
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Warna border hitam
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00', // Warna latar belakang kuning
                    ],
                ],
            ];

            // Tambahkan header (kolom)
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Code Category');
            $sheet->setCellValue('C1', 'Category');
            $sheet->setCellValue('D1', 'Group Category');
            $sheet->setCellValue('E1', 'Sub');

            $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

            // Ambil data dari database
            $categories = Category::all();

            // Isi data dari baris kedua
            $rowNumber = 2; // Mulai dari baris kedua
            foreach ($categories as $index => $category) {
                $sheet->setCellValue('A' . $rowNumber, $index + 1);
                $sheet->setCellValue('B' . $rowNumber, $category->code_category);
                $sheet->setCellValue('C' . $rowNumber, $category->category);
                $sheet->setCellValue('D' . $rowNumber, $category->group_category);
                $sheet->setCellValue('E' . $rowNumber, $category->sub);
                $rowNumber++;
            }
            // Menyesuaikan lebar kolom secara otomatis
            foreach (range('A', 'E') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Set nama file
            $fileName = 'categories_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Tulis file ke browser untuk diunduh
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        } catch (\Exception $e) {
            echo 'Terjadi kesalahan saat mengekspor file: ' . $e->getMessage();
        }
    }

    public function exportPDF(Request $request)
    {
        $categories = Category::all(); // Ganti 'Category' dengan model yang sesuai

        // Render view menjadi HTML
        $html = $this->generatePDFHtml($categories);
        $dompdf = new Dompdf();
        $dompdf->load_html($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        return $dompdf->stream('Category_list.pdf');
    }

    private function generatePDFHtml($categories)
    {
        // Awal HTML
        $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Category List</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f4f4f4;
            }
        </style>
    </head>
    <body>
        <h2>Data Category</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code Category</th>
                    <th>Category</th>
                    <th>Group</th>
                    <th>Sub</th>
                    <th>Validity</th>
                </tr>
            </thead>
            <tbody>';

        // Looping untuk memasukkan data kategori ke dalam HTML
        foreach ($categories as $index => $category) {
            $html .=
                "
        <tr>
            <td>" .
                ($index + 1) .
                "</td>
            <td>" .
                htmlspecialchars($category->code_category) .
                "</td>
            <td>" .
                htmlspecialchars($category->category) .
                "</td>
            <td>" .
                htmlspecialchars($category->group_category) .
                "</td>
            <td>" .
                htmlspecialchars($category->sub) .
                "</td>
            <td>" .
                ($category->validity ? 'Active' : 'Inactive') .
                "</td>
        </tr>";
        }

        // Akhir HTML
        $html .= '
            </tbody>
        </table>
    </body>
    </html>';

        return $html;
    }

    public function create(Request $request)
    {
        $category = Category::query()
            ->where('code_category', '=', $request->code_category)
            ->first();
        if ($category) {
            Response::json(['status' => 409, 'message' => 'Data Yang diinputkan sudah ada']);
        }
        Category::create([
            'uuid' => UUID::generateUuid(),
            'code_category' => $request->code_category,
            'category' => $request->category,
            'group_category' => $request->group,
            'sub' => $request->sub,
            'validity' => $request->validity,
        ]);
        return Response::json(['status' => 200]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::query()->where('uuid', '=', $id)->first();
        $category->category = $request->category;
        $category->group_category = $request->group;
        $category->sub = $request->sub;
        $category->validity = $request->validity;
        $category->updated_at = Date::Now();
        $category->save();
        return Response::json(['status' => 200]);
    }

    public function delete(Request $request, $id)
    {
        $category = Category::query()->where('uuid', '=', $id)->first();
        $category->deleted_at = Date::Now();
        $category->save();
        return Response::json(['status' => 200]);
    }
}

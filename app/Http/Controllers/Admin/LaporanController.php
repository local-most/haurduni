<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend as ChartLegend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
    	$bulan = $request->get('bulan');
    	$tahun = $request->get('tahun');

    	if ($bulan && $tahun) {
    		$order = Order::where('status', statusOrder('selesai-order'))
    						->where('tanggal')->get();
    		
    	}

    	$order = Order::where('status', statusOrder('selesai-order'))->get();
        return view('admin.laporan.index', compact('order'));
    }

    public function cetakExcel(Request $request)
    {

        $tanggal_awal=date('Y-m-d', strtotime($request->tahun.'-'.$request->bulan.'-01'));
        $tanggal_akhir=date('Y-m-t', strtotime($request->tahun.'-'.$request->bulan.'-01'));

        $filter_tanggal = rangeDate($tanggal_awal, $tanggal_akhir);

        $transaksi = Order::whereBetween('tanggal',[$tanggal_awal, $tanggal_akhir])
                            ->where('status', statusOrder('selesai-order'))
                            ->get();

        $spreadsheet = new Spreadsheet();

        $styleTextCenter = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $styleTextRight = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->mergeCells("A2:E2");
        $sheet->mergeCells("A3:E3");
        $sheet->mergeCells("A4:E4");
        $sheet->mergeCells("A5:E5");

        $sheet->setCellValue('A2', 'REKAP');
        $sheet->setCellValue('A3', 'TRANSAKSI');
        $sheet->setCellValue('A4', 'TOKO HARAPAN MULYA');
        $sheet->setCellValue('A5', 'PERIODE '.$filter_tanggal);

        $sheet->getStyle('A7:E7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('cacaca');
        $sheet->getStyle('A7:F7')->getFont()->setBold( true );
        $sheet->setCellValue('A7', 'No');
        $sheet->setCellValue('B7', 'Nama Pemesan');
        $sheet->setCellValue('C7', 'Tanggal');
        $sheet->setCellValue('D7', 'Jumlah Barang');
        $sheet->setCellValue('E7', 'Tagihan (Rp)');
        $i = 8;
        $no = 1;

        $jumlah_produk = [];
        $jumlah_harga = [];
        $jumlah_total = [];
        foreach ($transaksi as $row) {
            $sheet->setCellValue('A'.$i, $no++);
            $sheet->setCellValue('B'.$i, $row->User->nama);
            $sheet->setCellValue('C'.$i, tanggalIndo($row->tanggal));
            $sheet->setCellValue('E'.$i, rupiah($row->total_tagihan));

            $jumlah_harga[] = $row->harga_total;

            $jumlah_detail = [];

            foreach ($row->OrderDetail as $detail) {
                $jumlah_detail[] = $detail->jumlah;
            }
            $sheet->setCellValue('D'.$i, array_sum($jumlah_detail));

            $jumlah_produk[] = array_sum($jumlah_detail);
            
            $jumlah_total[] = $row->total_tagihan;

            $i++;
        }

        $rowCount = count($transaksi)+8;

        $sheet->mergeCells('A'.$rowCount.':C'.$rowCount);
        $sheet->getStyle('A'.$rowCount)->applyFromArray($styleTextCenter);
        $sheet->setCellValue('A'.$rowCount, 'JUMLAH TOTAL');
        $sheet->setCellValue('D'.$rowCount, array_sum($jumlah_produk));
        $sheet->setCellValue('E'.$rowCount, rupiah(array_sum($jumlah_total)));

        $i = $i;
        $sheet->getStyle('A7:E'.$i)->applyFromArray($styleBorder);
        $sheet->getStyle('A7:E7')->applyFromArray($styleTextCenter);

        $sheet->getStyle('D8:D'.$rowCount)->applyFromArray($styleTextCenter);
        $sheet->getStyle('E8:E'.$rowCount)->applyFromArray($styleTextRight);

        $sheet->getStyle('A2:F5')->applyFromArray($styleTextCenter);

        $i +=4;
        $sheet->mergeCells("D$i:E$i");
        $sheet->setCellValue('D'.$i, 'Kuningan, '.tanggalIndo(now()));
        $i +=1;
        $sheet->mergeCells("D$i:E$i");
        $sheet->setCellValue('D'.$i, 'Pimpinan Toko Harapan Mulya');
        $i +=3;
        $sheet->mergeCells("D$i:E$i");
        $sheet->setCellValue('D'.$i, 'Engkos Kosasih');

        $namafile = 'laporan-transaksi-'.bulanIndo($request->bulan).'-'.$request->tahun.'.xlsx';
        $response = response()->streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->setIncludeCharts(true);
            $writer->save('php://output');
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$namafile.'"');
        $response->send();

    }

    public function getChart(Request $request)
    {
        $tanggal_awal=date('Y-m-d', strtotime($request->tahun.'-'.$request->bulan.'-01'));
        $tanggal_akhir=date('Y-m-t', strtotime($request->tahun.'-'.$request->bulan.'-01'));

        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, (int) $request->bulan, (int) $request->tahun);

        $tanggals = [];
        $transaksi = [];

        for($i=1; $i<=$jumlah_hari; $i++){
            $tgl=date('Y-m-d', strtotime($request->tahun.'-'.$request->bulan.'-'.$i));
            $trx = Order::select(\DB::raw("SUM(total_harga) as total"))
                ->whereDate('tanggal', $tgl)
                ->where('status', statusOrder('selesai-order'))
                ->pluck('total');

            $tanggals[] = $i;
            $transaksi[] = $trx[0] ? $trx[0] : 0;
        }

        $filter_tanggal = rangeDate($tanggal_awal, $tanggal_akhir);

        return response()->json([
            "jumlah_transaksi" => null,
            "total_transaksi" => $transaksi,
            "tanggals" => $tanggals,
        ]);
    }

    public function getChartPelanggan(Request $request)
    {
        $tanggal_awal=date('Y-m-d', strtotime($request->tahun.'-'.$request->bulan.'-01'));
        $tanggal_akhir=date('Y-m-t', strtotime($request->tahun.'-'.$request->bulan.'-01'));

        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, (int) $request->bulan, (int) $request->tahun);

        $pelanggan = User::with(['Orders' => function ($query) use ($tanggal_awal, $tanggal_akhir) {
                        return $query->whereBetween('tanggal', [$tanggal_awal, $tanggal_akhir]);
                    }])
                    ->select(
                        'users.id',
                        'users.nama',
                    )
                    ->where('role', 2)->get();

        $names = [];
        $jumlahTransaksi = [];
        $duplicate = null;

        foreach($pelanggan as $row) {
            $names[] = $row->nama; 
            $total = 0;
            foreach($row->Orders as $order) {
                $total += $order->total_tagihan;
            }
            $jumlahTransaksi[] = $total;
        }

        return response()->json([
            "names" => $names,
            "jumlahTransaksi" => $jumlahTransaksi,
        ]);
    }

    public function getChartProduk(Request $request)
    {
        $tanggal_awal=date('Y-m-d', strtotime($request->tahun.'-'.$request->bulan.'-01'));
        $tanggal_akhir=date('Y-m-t', strtotime($request->tahun.'-'.$request->bulan.'-01'));

        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, (int) $request->bulan, (int) $request->tahun);

        $produks = Produk::with(
            [
                'OrderDetail.Order' => function ($query) use ($tanggal_awal, $tanggal_akhir) {
                    return $query->whereBetween('tanggal', [
                        $tanggal_awal, $tanggal_akhir
                    ]);
                },
            ])
            ->get();

        $names = [];
        $jumlahTransaksi = [];
        $color = [];

        foreach($produks as $row) {
            $names[] = $row->nama;
            $total = 0;
            foreach ($row->OrderDetail as $detail) {
                $total += $detail->harga * $detail->jumlah;
            }
            $jumlahTransaksi[] = $total;
            $color[] = hexToRgb(random_color());
        }

        return response()->json([
            "names" => $names,
            "jumlahTransaksi" => $jumlahTransaksi,
            "color" => $color,
        ]);
    }
}

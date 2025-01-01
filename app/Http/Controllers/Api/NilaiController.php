<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NilaiModel;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function hitungNilaiRT() {
        $pelajaranYangDihitung = [
            'artistic' => 'ARTISTIC',
            'conventional' => 'CONVENTIONAL',
            'enterprising' => 'ENTERPRISING',
            'investigative' => 'INVESTIGATIVE',
            'realistic' => 'REALISTIC',
            'social' => 'SOCIAL',
        ];

        $query = NilaiModel::query()->select(['nama', 'nisn']);

        foreach ($pelajaranYangDihitung as $key => $value) {
            $query->selectRaw("SUM(CASE WHEN nama_pelajaran = '$value' THEN skor ELSE 0 END) AS $key");
        }

        $results = $query->where('materi_uji_id', 7)->where('nama_pelajaran', '<>', 'Pelajaran Khusus')->groupBy('nama', 'nisn')->get();

        $formattedResults = $results->reduce(function ($carry, $item, $index) {
            $carry[(string) $index] = [
                'nama' => $item->nama,
                'nilaiRT' => [
                    'artistic' => $item->artistic,
                    'conventional' => $item->conventional,
                    'enterprising' => $item->enterprising,
                    'investigative' => $item->investigative,
                    'realistic' => $item->realistic,
                    'social' => $item->social,
                ],
                'nisn' => $item->nisn,
            ];

            return $carry;
        }, []);

        return response()->json((object) $formattedResults, 200);
    }

    public function hitungNilaiST() {
        $query = NilaiModel::query()->select(['nama', 'nisn']);

        $pelajaranYangDihitung = array(
            array('nama_pelajaran' => 'Verbal', 'key' => 'verbal', 'dikali' => 41.67),
            array('nama_pelajaran' => 'Kuantitatif', 'key' => 'kuantitatif', 'dikali' => 29.67),
            array('nama_pelajaran' => 'Penalaran', 'key' => 'penalaran', 'dikali' => 100),
            array('nama_pelajaran' => 'Figural', 'key' => 'figural', 'dikali' => 23.81)
        );

        $totalNilaiExpression = '';

        foreach ($pelajaranYangDihitung as $value) {
            $query->selectRaw("(SUM(CASE WHEN nama_pelajaran = '$value[nama_pelajaran]' THEN skor ELSE 0 END) * $value[dikali]) AS $value[key]");

            $totalNilaiExpression .= "SUM(CASE WHEN nama_pelajaran = '{$value['nama_pelajaran']}' THEN skor ELSE 0 END) * {$value['dikali']} + ";
        }

        $totalNilaiExpression = rtrim($totalNilaiExpression, ' + ');

        $query->selectRaw("($totalNilaiExpression) AS totalNilai");

        $results = $query->where('materi_uji_id', 4)->groupBy('nama', 'nisn')->orderBy('totalNilai', 'desc')->get();

        $formattedResults = $results->reduce(function ($carry, $item, $index) {
            $carry[(string) $index] = [
                'nama' => $item->nama,
                'nilaiST' => [
                    'figural' => $item->figural,
                    'kuantitatif' => $item->kuantitatif,
                    'penalaran' => $item->penalaran,
                    'verbal' => $item->verbal
                ],
                'nisn' => $item->nisn,
                'totalNilai' => $item->totalNilai,
            ];

            return $carry;
        }, []);

        return response()->json((object) $formattedResults, 200);
    }
}

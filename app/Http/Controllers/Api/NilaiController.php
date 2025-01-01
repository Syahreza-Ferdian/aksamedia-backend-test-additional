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
}

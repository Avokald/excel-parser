<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadExcelFileToParseRowRequest;
use App\Models\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class RowController extends Controller
{
    /**
     * Страница отображения таблицы rows
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Row::all();

        $rowsGroupedByDay = [];
        foreach ($rows as $row) {
            $day = (int) $row->date->format('d');

            if (array_key_exists($day, $rowsGroupedByDay)) {
                $rowsGroupedByDay[$day][] = $row;
            } else {
                $rowsGroupedByDay[$day] = [$row];
            }
        }
        ksort($rowsGroupedByDay);

        return view('welcome', [
            'rowsGroupedByDay' => $rowsGroupedByDay,
        ]);
    }

    /**
     * Страница загрузки файла
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function upload()
    {
        return view('upload');
    }

    /**
     * Обработчик загрузки файла
     *
     * @param UploadExcelFileToParseRowRequest $request
     *
     * @return array
     */
    public function process(UploadExcelFileToParseRowRequest $request): array
    {
        $fileToParse = $request->file('file');

        if (empty($fileToParse)) {
            return ['status' => false];
        }

        $rowsImport = new \App\Imports\RowsImport();

        $counterFieldName = 'counter_' . (string) Str::uuid();

        Redis::set($counterFieldName, 0);

        $rowsImport->setCounterFieldName($counterFieldName);

        Excel::queueImport($rowsImport, $fileToParse);

        return ['status' => true];
    }
}

<?php

namespace App\Imports;

use App\Events\NotifyNewRowCreated;
use App\Jobs\UpdateFileParsingProgress;
use App\Models\Row;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RowsImport implements ToModel, ShouldQueue, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    private $counterFieldName;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (is_numeric($row['date'])) {
            $date = Date::excelToDateTimeObject($row['date']);
        }

        if (isset($row['name']) && !empty($date)) {

            $date = Carbon::instance($date);

            $rowEntity = new Row([
                'name' => $row['name'],
                'date' => $date,
            ]);

            $counter = (int)Redis::get($this->counterFieldName) + 1;
            Redis::set($this->counterFieldName, $counter);

            dispatch(new UpdateFileParsingProgress($counter))->onQueue('pusher');

            return $rowEntity;
        }
        return null;
    }

    /**
     * @param string $counterFieldName
     */
    public function setCounterFieldName(string $counterFieldName): void
    {
        $this->counterFieldName = $counterFieldName;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}

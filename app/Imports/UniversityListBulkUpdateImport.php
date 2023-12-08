<?php

namespace App\Imports;

use App\Models\University;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UniversityListBulkUpdateImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
  /**
   * @param Collection $collection
   */
  public function startRow(): int
  {
    return 2;
  }
  public function collection(collection $rows)
  {
    $rowsInserted = 0;
    $totalRows = 0;
    foreach ($rows as $row) {

      $field = University::find($row['id']);

      $field->name = $row['name'];
      $field->slug = slugify($row['name']);
      $field->institute_type = $row['institute_type'];
      $field->address = $row['address'];
      $field->city = $row['city'];
      $field->state = $row['state'];
      $field->country = $row['country'];
      $field->email = $row['email'];
      $field->email2 = $row['email2'];
      $field->email3 = $row['email3'];
      $field->phone_number = $row['phone_number'];
      $field->phone_number2 = $row['phone_number2'];
      $field->phone_number3 = $row['phone_number3'];
      $field->whatsapp = $row['whatsapp'];

      $field->save();
      $rowsInserted++;
      $totalRows++;
    }
    if ($rowsInserted > 0) {
      session()->flash('smsg', $rowsInserted . ' out of ' . $totalRows . ' rows imported succesfully.');
    } else {
      session()->flash('emsg', 'Data not imported. Duplicate rows found.');
    }
  }

  public function chunkSize(): int
  {
    return 1000;
  }
  public function batchSize(): int
  {
    return 1000;
  }
}

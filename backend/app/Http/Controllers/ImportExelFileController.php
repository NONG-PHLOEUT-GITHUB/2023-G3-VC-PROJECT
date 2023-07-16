<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUsers;
use Illuminate\Support\Facades\Storage;

class ImportExelFileController extends Controller
{
  
    ///https://larachamp.com/how-to-import-excel-file-to-database-in-laravel/
    public function import(Request $request)
    {

        $file = $request->file('file');

        if (!$file) {
            return response()->json([
                'message' => 'No file uploaded'
            ], 400);
        }

        $filePath = Storage::putFile('files', $file);
        // $import = new ImportUsers();
        Excel::import(new ImportUsers, storage_path('app/' . $filePath));

        Storage::delete($filePath);

        // $importCount = $import->getImportCount();
        // dd($importCount);
        // return response()->json([
        //     'message' => 'Import successful',
        //     'imported' => $importCount['imported'],
        //     'skipped' => $importCount['skipped'],
        // ]);
        return response()->json([
            'message' => 'import successfully',
            'data' => $filePath
        ]);
    }
}

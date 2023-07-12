<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelFileController extends Controller
{
    public function import(Request $request)
    {
        // dd($request->hasFile('excel'));
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('files');
            Excel::import(new UsersImport, $file);
            return response()->json([
                'message' => 'Import successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'No file uploaded'
            ]);
        }
    }
}

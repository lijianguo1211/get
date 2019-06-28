<?php

use Maatwebsite\Excel\Excel;

class LiYiController
{
    public function importExcel()
    {
        $file = request()->file('liyi');
        Excel::import(new LiYiImport(), $file);
    }
}

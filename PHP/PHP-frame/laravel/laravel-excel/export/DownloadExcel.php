<?php
/**
 * Notes:
 * File name:DownloadExcel
 * Create by: Jay.Li
 * Created on: 2019\6\18 0018 11:51
 */

use Maatwebsite\Excel\Facades\Excel;

class DownloadExcel
{
    const XLSX     = 'Xlsx';

    const CSV      = 'Csv';

    const TSV      = 'Csv';

    const ODS      = 'Ods';

    const XLS      = 'Xls';

    const SLK      = 'Slk';

    const XML      = 'Xml';

    const GNUMERIC = 'Gnumeric';

    const HTML     = 'Html';

    const MPDF     = 'Mpdf';

    const DOMPDF   = 'Dompdf';

    const TCPDF    = 'Tcpdf';
    /**
     * Notes: 下载到本地
     * Function Name: downloadWindows
     * User: Jay.Li
     * Date: 2019\6\18 0018
     * Time: 11:53
     */
    public function downloadWindows()
    {
        /**
         * 参数一：导出逻辑类
         * 参数二：导出文件名
         * 参数二：导出文件格式，默认为null，导出的是xslx格式，
         * 参数二：导出设置额外的header参数默认为空，数组形式
         */
        Excel::download(new LiYiExport(), 'test.csv','','');
    }

    /**
     * Notes: 下载到磁盘，下载到服务器上
     * Function Name: downloadStore
     * User: Jay.Li
     * Date: 2019\6\18 0018
     * Time: 11:55
     */
    public function downloadStore()
    {
        /**
         * 参数一：下载具体的逻辑类
         * 参数二：下载的文件名
         * 参数三：下载到磁盘的那个磁盘上，指定磁盘
         * 参数四：下载导出的格式，默认不填写为null，也就是Excel::XLSX
         * 参数五：传递给磁盘的参数，数组形式的参数
         *
         */
        Excel::store(new LiYiExport(), 'test.csv', 's3',Excel::XLSX,'');
    }

    /**
     * 磁盘的配置在app/filesystems.php文件
     *'local' => [
    'driver' => 'local',
    'root' => storage_path('app'),
    ],

    'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
    ],

    's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    ],
     */
}

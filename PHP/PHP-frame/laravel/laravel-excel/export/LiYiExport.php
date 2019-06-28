<?php
/**
 * Notes:
 * File name:LiYiExport
 * Create by: Jay.Li
 * Created on: 2019\6\18 0018 10:54
 */

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LiYiExport implements FromCollection, WithEvents
{
    public function collection()
    {
        // TODO: Implement collection() method.
        /*
         * 实现一：以model类的查询方法 all();
         * LiYiModel::all();
         */

        if (!true) {
            return $result = LiYiModel::all();
        }
        /**
         * 实现二：自己构造一个二维数组，
         */
        $result = [
            [1,2,3],
            [4,5,6],
            [7,8,9]
        ];

        return new Collection($result);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                //获取当前sheet工作表
                $workSheet = $event->sheet()->getDelegate();
                //设置表头字体为16；
                $cellRange = 'A1:W1';
                $workSheet->getStyle($cellRange)->getFont()->getSize(16);

                // 将样式数组应用于B2：G8范围单元格
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ]
                    ]
                ];

                //获取总行数
                $end = $workSheet->getCellCollection()->getHighestRow();

                $cellRangeContent = 'A2:W'.$end;
                //设置表格样式
                $workSheet->getStyle($cellRangeContent)->applyFromArray($styleArray);

                //设置内容行的宽度

                $arrayColumn = [
                    'B' => 30,
                    'D' => 60,
                    'G' => 90,
                ];
                foreach ($arrayColumn as $k => $item) {
                    //获取特定的列，设置它的宽度
                    $workSheet->getColumnDimension($k)->setWidth($item);
                }

                //设置自动换行，文本居中
                $workSheet->getStyle($cellRangeContent)->getAlignment()
                    ->setWrapText(true)->setVertical("center")
                    ->setHorizontal("center");
            }
        ];
    }
}


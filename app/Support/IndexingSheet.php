<?php

namespace App\Support;

use RuntimeException;
use ZipArchive;

/**
 * Builds a small .xlsx file (no external library) with a dropdown column.
 * A plain CSV cannot hold dropdowns or pasted screenshots, so this is an Excel file.
 */
class IndexingSheet
{
    public const STATUSES = ['Indexed', 'Not Indexed', 'Pending'];

    /**
     * @param array<int, array{url:string, date:string}> $rows
     * @return string path to a temporary .xlsx file
     */
    public static function build(array $rows): string
    {
        $path = tempnam(sys_get_temp_dir(), 'idx') . '.xlsx';
        $zip = new ZipArchive();
        if ($zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Could not create the spreadsheet file.');
        }

        $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>');

        $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>');

        $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Indexing" sheetId="1" r:id="rId1"/></sheets></workbook>');

        $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>');

        // style 0 = normal, 1 = bold header, 2 = wrapped + top aligned
        $zip->addFromString('xl/styles.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font></fonts>'
            . '<fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE8EDFF"/><bgColor indexed="64"/></patternFill></fill></fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="3">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"><alignment vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="top" wrapText="1"/></xf>'
            . '</cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>');

        $e = fn (string $v) => htmlspecialchars($v, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $last = count($rows) + 1;

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'
            . '<cols><col min="1" max="1" width="70" customWidth="1"/><col min="2" max="2" width="20" customWidth="1"/>'
            . '<col min="3" max="3" width="16" customWidth="1"/><col min="4" max="4" width="45" customWidth="1"/></cols>'
            . '<sheetData>';

        $xml .= '<row r="1" ht="24" customHeight="1">';
        foreach (['Post Link', 'Post Date & Time', 'Indexing Status', 'Screenshot'] as $i => $h) {
            $xml .= '<c r="' . chr(65 + $i) . '1" t="inlineStr" s="1"><is><t>' . $e($h) . '</t></is></c>';
        }
        $xml .= '</row>';

        foreach (array_values($rows) as $i => $r) {
            $n = $i + 2;
            $url = $e($r['url']);
            // Row is tall enough to paste a screenshot into the last column.
            $xml .= '<row r="' . $n . '" ht="90" customHeight="1">'
                . '<c r="A' . $n . '" t="str" s="2"><f>HYPERLINK("' . str_replace('"', '""', $url) . '")</f><v>' . $url . '</v></c>'
                . '<c r="B' . $n . '" t="inlineStr" s="2"><is><t>' . $e($r['date']) . '</t></is></c>'
                . '<c r="C' . $n . '" t="inlineStr" s="2"><is><t>Pending</t></is></c>'
                . '<c r="D' . $n . '" s="2"/>'
                . '</row>';
        }

        $xml .= '</sheetData>';
        $xml .= '<dataValidations count="1"><dataValidation type="list" allowBlank="1" showErrorMessage="1" sqref="C2:C' . max($last, 2) . '">'
            . '<formula1>"' . implode(',', self::STATUSES) . '"</formula1></dataValidation></dataValidations>';
        $xml .= '</worksheet>';

        $zip->addFromString('xl/worksheets/sheet1.xml', $xml);
        $zip->close();

        return $path;
    }
}

<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class ResumeParserService
{
    public function parse($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($extension === 'pdf') {
            return $this->parsePdf($filePath);
        } elseif (in_array($extension, ['doc', 'docx'])) {
            return $this->parseDocx($filePath);
        }

        return null;
    }

    private function parsePdf($filePath)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($filePath);
        return $pdf->getText();
    }

    private function parseDocx($filePath)
    {
        // For now, basic docx support
        $zip = new \ZipArchive();
        $zip->open($filePath);
        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        return $dom->textContent;
    }
}
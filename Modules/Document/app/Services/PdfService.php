<?php

namespace Modules\Document\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    /**
     * Generate a PDF from a Blade view.
     *
     * @param  string  $view  View name (e.g. 'document::templates.order-receipt-a4')
     * @param  array<string, mixed>  $data  Data to pass to the view
     * @param  string|float[]  $paperSize  Paper size: 'a4', 'letter', or array [0, 0, width_pt, height_pt]
     * @param  string  $orientation  'portrait' or 'landscape'
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generate(string $view, array $data, string|array $paperSize = 'a4', string $orientation = 'portrait')
    {
        $pdf = Pdf::loadView($view, $data);

        if (is_array($paperSize)) {
            $pdf->setPaper($paperSize, $orientation);
        } else {
            $pdf->setPaper($paperSize, $orientation);
        }

        return $pdf;
    }
}

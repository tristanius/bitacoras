<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 0.5cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 8px; line-height: 1; }
        .page-container { page-break-after: always; height: 100%; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-bottom: 5px; }
        th, td { border: 1px solid #000; padding: 2px; text-align: center; height: 18px; }
        th { background-color: #e9e9e9; font-size: 7px; }
        .section-title { font-weight: bold; background: #ddd; text-align: left; padding-left: 5px; }
        .totals-row { font-weight: bold; background: #f5f5f5; }
        .header-info { margin-bottom: 10px; width: 100%; }
    </style>
</head>
<body>
    @php 
        $totalsToDate = ['total' => 0, 'pic' => 0, 'sic' => 0, 'night' => 0, 'instr' => 0, 'xc' => 0, 'land_d' => 0, 'land_n' => 0, 'app' => 0];
    @endphp

    @foreach($chunks as $index => $chunk)
        @php
            $amountForwarded = $totalsToDate; // Lo que traíamos de la página anterior
            $pageTotals = [
                'total' => $chunk->sum('total_time'),
                'pic' => $chunk->sum('pic_time'),
                'sic' => $chunk->sum('sic_time'),
                'night' => $chunk->sum('night_time'),
                'instr' => $chunk->sum('instr_actual'),
                'xc' => $chunk->sum('xc_time'),
                'land_d' => $chunk->sum('landings_day'),
                'land_n' => $chunk->sum('landings_night'),
                'app' => $chunk->sum('approaches'),
            ];
            // Actualizamos el "To Date" para la siguiente página
            foreach($totalsToDate as $key => $val) { $totalsToDate[$key] += $pageTotals[$key]; }
        @endphp

        <div class="page-container">
            <table class="header-info" style="border:none;">
                <tr>
                    <td style="border:none; text-align:left; font-size:12px;"><strong>PILOT LOGBOOK:</strong> {{ $pilot->name }}</td>
                    <td style="border:none; text-align:right;">PÁGINA {{ $index + 1 }}</td>
                </tr>
            </table>

            <div class="section-title">A. FLIGHT INFORMATION & DURATION</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:10%">DATE</th>
                        <th style="width:15%">AIRCRAFT MODEL</th>
                        <th style="width:15%">IDENT</th>
                        <th style="width:10%">FROM</th>
                        <th style="width:10%">TO</th>
                        <th>TOTAL TIME</th>
                        <th>PIC</th>
                        <th>SIC</th>
                        <th>XC</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chunk as $entry)
                    <tr>
                        <td>{{ $entry->date }}</td>
                        <td>{{ $entry->aircraft->aircraft_model->name ?? '' }}</td>
                        <td>{{ $entry->aircraft->registration }}</td>
                        <td>{{ $entry->origin->icao_code }}</td>
                        <td>{{ $entry->destination->icao_code }}</td>
                        <td>{{ number_format($entry->total_time, 1) }}</td>
                        <td>{{ number_format($entry->pic_time, 1) }}</td>
                        <td>{{ number_format($entry->sic_time, 1) }}</td>
                        <td>{{ number_format($entry->xc_time, 1) }}</td>
                    </tr>
                    @endforeach
                    @for($i = count($chunk); $i < 12; $i++)
                        <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    @endfor
                </tbody>
            </table>

            <div class="section-title">B. CONDITIONS, LANDINGS & REMARKS</div>
            <table>
                <thead>
                    <tr>
                        <th>NIGHT</th>
                        <th>INSTR. ACTUAL</th>
                        <th>LANDINGS (D/N)</th>
                        <th>APPROACHES</th>
                        <th style="width:40%">REMARKS / ENDORSEMENTS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chunk as $entry)
                    <tr>
                        <td>{{ number_format($entry->night_time, 1) }}</td>
                        <td>{{ number_format($entry->instr_actual, 1) }}</td>
                        <td>{{ $entry->landings_day }} / {{ $entry->landings_night }}</td>
                        <td>{{ $entry->approaches }}</td>
                        <td style="text-align:left; font-size:7px;">{{ Str::limit($entry->remarks, 80) }}</td>
                    </tr>
                    @endforeach
                    @for($i = count($chunk); $i < 12; $i++)
                        <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                    @endfor
                </tbody>
            </table>

            <table>
                <tr class="totals-row">
                    <td style="width:20%">PAGE TOTALS</td>
                    <td>TIME: {{ number_format($pageTotals['total'], 1) }}</td>
                    <td>PIC: {{ number_format($pageTotals['pic'], 1) }}</td>
                    <td>NIGHT: {{ number_format($pageTotals['night'], 1) }}</td>
                    <td>LAND: {{ $pageTotals['land_d'] + $pageTotals['land_n'] }}</td>
                    <td>APP: {{ $pageTotals['app'] }}</td>
                </tr>
                <tr class="totals-row">
                    <td>AMOUNT FORWARDED</td>
                    <td>TIME: {{ number_format($amountForwarded['total'], 1) }}</td>
                    <td>PIC: {{ number_format($amountForwarded['pic'], 1) }}</td>
                    <td>NIGHT: {{ number_format($amountForwarded['night'], 1) }}</td>
                    <td>LAND: {{ $amountForwarded['land_d'] + $amountForwarded['land_n'] }}</td>
                    <td>APP: {{ $amountForwarded['app'] }}</td>
                </tr>
                <tr class="totals-row" style="background:#e0e0e0;">
                    <td>TOTALS TO DATE</td>
                    <td>TIME: {{ number_format($totalsToDate['total'], 1) }}</td>
                    <td>PIC: {{ number_format($totalsToDate['pic'], 1) }}</td>
                    <td>NIGHT: {{ number_format($totalsToDate['night'], 1) }}</td>
                    <td>LAND: {{ $totalsToDate['land_d'] + $totalsToDate['land_n'] }}</td>
                    <td>APP: {{ $totalsToDate['app'] }}</td>
                </tr>
            </table>
        </div>
    @endforeach
</body>
</html>
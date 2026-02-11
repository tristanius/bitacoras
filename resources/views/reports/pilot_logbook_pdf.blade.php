<!DOCTYPE html>
<html>
<head>
    <title>Logbook Report</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>REGISTRO DE VUELO - BITÁCORA DE PILOTO</h2>
        <p>Piloto: <strong>{{ $pilot->name }}</strong> | Periodo: {{ $request->start_date }} al {{ $request->end_date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Fecha</th>
                <th rowspan="2">Avión</th>
                <th rowspan="2">Model / Class</th>
                <th colspan="2">Ruta</th>
                <th colspan="2">Hobbs</th>
                <th rowspan="2">Total</th>
                <th colspan="5">Condiciones / Tipo de Tiempo</th>
                <th rowspan="2">Instructor</th>
            </tr>
            <tr>
                <th>Origen</th><th>Dest</th>
                <th>Out</th><th>In</th>
                <th>PIC</th><th>SIC</th><th>Solo</th><th>Dual</th><th>XC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
            <tr>
                <td>{{ $entry->date }}</td>
                <td>{{ $entry->aircraft->registration }}</td>
                <td>{{ $entry->aircraft->model->name }} / {{ $entry->aircraft->model->category->name }}</td>
                <td>{{ $entry->origin->icao_code }}</td>
                <td>{{ $entry->destination->icao_code }}</td>
                <td>{{ $entry->hobbs_out }}</td>
                <td>{{ $entry->hobbs_in }}</td>
                <td><strong>{{ $entry->total_time }}</strong></td>
                <td>{{ $entry->pic_time }}</td>
                <td>{{ $entry->sic_time }}</td>
                <td>{{ $entry->solo_time }}</td>
                <td>{{ $entry->dual_time }}</td>
                <td>{{ $entry->xc_time }}</td>
                <td>{{ $entry->instructor->name ?? 'N/A' }} - {{ $entry->validated? '(OK)':'' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #eee; font-weight: bold;">
                <td colspan="7" style="text-align: right;">TOTAL HORAS EN EL PERIODO:</td>
                <td>{{ $entries->sum('total_time') }}</td>
                <td colspan="6"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">Generado el: {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>
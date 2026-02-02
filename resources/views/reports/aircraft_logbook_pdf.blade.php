<!DOCTYPE html>
<html>
<head>
    <title>Logbook Aeronave - {{ $aircraft->registration }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 5px; text-align: center; }
        th { background-color: #e9ecef; color: #000; font-weight: bold; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #0b5394; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #0b5394; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8px; font-style: italic; }
        .total-row { background-color: #f8f9fa; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>REPORTE HISTÓRICO DE AERONAVE</h2>
        <p>
            Matrícula: <strong>{{ $aircraft->registration }}</strong> | 
            Modelo: <strong>{{ $aircraft->model->name?? 'N/A' }} / {{ $aircraft->model->category->name ?? 'N/A' }}</strong><br>
            Periodo de Consulta: {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Piloto al Mando</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Hobbs Salida</th>
                <th>Hobbs Entrada</th>
                <th>Tiempo Total</th>
                <th>Aterrizajes (D/N)</th>
                <th>Check instruc.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
            <tr>
                <td>{{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }}</td>
                <td>{{ $entry->pilot->name }}</td>
                <td>{{ $entry->origin->icao_code }}</td>
                <td>{{ $entry->destination->icao_code }}</td>
                <td>{{ number_format($entry->hobbs_out, 1) }}</td>
                <td>{{ number_format($entry->hobbs_in, 1) }}</td>
                <td style="background-color: #fff9db;"><strong>{{ number_format($entry->total_time, 1) }}</strong></td>
                <td>{{ $entry->landings_day }} / {{ $entry->landings_night }}</td>
                <td>{{ (isset($entry->instructor_id))? (($entry->validated && $entry->instructor_id)  ? 'VALIDADO' : 'NO VALIDADO') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6" style="text-align: right;">TOTAL HORAS VOLADAS EN EL PERIODO:</td>
                <td style="background-color: #dbe4ff;">{{ number_format($entries->sum('total_time'), 1) }} hrs</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generado por Sistema de Bitácora - {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
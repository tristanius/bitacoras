<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 0.5cm; size: letter landscape;}
        body { 
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 7px; 
            margin: 0; 
            padding: 0;
        }
        .page-break { 
            page-break-after: always; 
        }
        .page-container { 
            width: 100%;
            position: relative;
            padding: 0px;
            margin: 0px;
        }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-bottom: 5px; }
        th, td { border: 1px solid #000; padding: 2px; text-align: center; height: 18px;font-size: 7px; }
        th { background-color: #e9e9e9; font-size: 7px; }
        .section-title { font-weight: bold; background: #ddd; text-align: left; padding-left: 5px; }
        .totals-row { font-weight: bold; background: #f5f5f5; }
        .header-info { margin-bottom: 10px; width: 100%; }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
    @php 
        $totalsToDate = [
            'total' => 0,             
            'night' => 0, 
            'instr' => 0, 
            'instr_sim'=>0,
            'sim_time'=>0,
            'xc' => 0, 
            'solo' => 0, 
            'pic' => 0, 
            'sic' => 0, 
            'dual'=>0,
            'cfi'=>0,
            'land_d' => 0, 
            'land_n' => 0, 
            'app' => 0
            ];
        $classTotals = [
            'ASEL' => 0,
            'ASES' => 0,
            'AMEL' => 0,
            'AMES' => 0,
            'JET' => 0,
            'HELI' => 0,
            'GLIDER' => 0,
            'PCATO' => 0,
            ];
    @endphp

    @foreach($chunks as $index => $chunk)
        @php
            $amountForwarded = $totalsToDate; // Lo que traíamos de la página anterior
            $classForwarded = $classTotals; // Lo que traíamos de la página anterior
            $pageTotals = [
                'total' => $chunk->sum('total_time'),                
                'night' => $chunk->sum('night_time'),
                'instr' => $chunk->sum('instr_actual'),
                'instr_sim' => $chunk->sum('instr_sim'),
                'sim_time' => $chunk->sum('simulated_time'),
                'xc' => $chunk->sum('xc_time'),
                'solo' => $chunk->sum('solo_time'),
                'pic' => $chunk->sum('pic_time'),
                'sic' => $chunk->sum('sic_time'),
                'dual' => $chunk->sum('dual_time'),
                'cfi' => $chunk->sum('cfi_time'),
                'land_d' => $chunk->sum('landings_day'),
                'land_n' => $chunk->sum('landings_night'),
                'app' => $chunk->sum('approaches'),
            ];
            $classPage = [
                'ASEL' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'ASEL'))->sum('total_time'),
                'ASES' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'ASES'))->sum('total_time'),
                'AMEL' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'AMEL'))->sum('total_time'),
                'AMES' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'AMES'))->sum('total_time'),
                'JET' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'JET'))->sum('total_time'),
                'HELI' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'HELI'))->sum('total_time'),
                'GLIDER' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'GLIDER'))->sum('total_time'),
                'PCATO' => $chunk->filter(fn($e) => str_contains($e->aircraft->aircraft_model->category->name ?? '', 'PCATO'))->sum('total_time'),
            ];
            // Actualizamos el "To Date" para la siguiente página
            foreach($totalsToDate as $key => $val) { $totalsToDate[$key] += $pageTotals[$key]; }
            foreach($classTotals as $key => $val) { $classTotals[$key] += $classPage[$key]; }
        @endphp

        <div class="page-container">
            <table class="header-info" style="border:none;">
                <tr>
                    <td style="border:none; text-align:left; font-size:10px;"><strong>PILOT LOGBOOK:</strong> {{ $pilot->name }}</td>
                    <td style="border:none; text-align:right; font-size:10px;">PÁGINA {{ $index + 1 }}</td>
                </tr>
            </table>

            <table>
                <thead>
                    <tr>
                        <th style="width:10%" rowspan="2">DATE</th>
                        <th style="width:10%" rowspan="2">CLASS / MODEL</th>
                        <th rowspan="2">IDENT</th>
                        <th colspan="2">ROUTE</th>
                        <th rowspan="2">TOTAL TIME OF TIME</th>
                        <th colspan="8">AIRCRAFT </th>
                        <th colspan="2">LANDINGS</th>
                    </tr>
                    <tr>
                        <th>FROM</th>
                        <th>TO</th>
                        <th>ASEL</th>
                        <th>ASES</th>
                        <th>AMEL</th>
                        <th>AMES</th>
                        <th>JET</th>
                        <th>HELI</th>
                        <th>CLIDER</th>
                        <th>PCATO</th>
                        <th>D</th>
                        <th>N</th>
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
                        <td>{{ ($entry->aircraft->model->category->name == "ASEL")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ ($entry->aircraft->model->category->name == "ASES")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ ($entry->aircraft->model->category->name == "AMEL")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ ($entry->aircraft->model->category->name == "AMES")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ ($entry->aircraft->model->category->name == "JET")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ ($entry->aircraft->model->category->name == "HELI")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ ($entry->aircraft->model->category->name == "GLIDER")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ ($entry->aircraft->model->category->name == "PCATO")?number_format($entry->total_time, 1): 0; }}</td>
                        <td>{{ $entry->landings_day }}</td>
                        <td>{{ $entry->landings_night }}</td>
                    </tr>
                    @endforeach
                    @for($i = count($chunk); $i < 8; $i++)
                        <tr>
                            @for($j=0; $j<= 15; $j++)
                                <td>&nbsp;</td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" rowspan="3">Signature:</th>
                        <th colspan="2">PG. TOTALs</th>
                        <th>{{ number_format($pageTotals['total'], 1) }}</th>
                        <th>{{ number_format($classPage['ASEL'], 1) }}</th>
                        <th>{{ number_format($classPage['ASES'], 1) }}</th>
                        <th>{{ number_format($classPage['AMEL'], 1) }}</th>
                        <th>{{ number_format($classPage['AMES'], 1) }}</th>
                        <th>{{ number_format($classPage['JET'], 1) }}</th>
                        <th>{{ number_format($classPage['HELI'], 1) }}</th>
                        <th>{{ number_format($classPage['GLIDER'], 1) }}</th>
                        <th>{{ number_format($classPage['PCATO'], 1) }}</th>
                        <th>{{ $pageTotals['land_d'] }}</th>
                        <th> {{$pageTotals['land_n'] }}</th>
                    </tr>
                    <tr>
                        <th colspan="2">AMOUNT FORWD.</th>
                        <th>{{ number_format($amountForwarded['total'], 1) }}</th>
                        <th>{{number_format($classForwarded['ASEL'], 1) }}</th>
                        <th>{{number_format($classForwarded['ASES'], 1) }}</th>
                        <th>{{number_format($classForwarded['AMEL'], 1) }}</th>
                        <th>{{number_format($classForwarded['AMES'], 1) }}</th>
                        <th>{{number_format($classForwarded['JET'], 1) }}</th>
                        <th>{{number_format($classForwarded['HELI'], 1) }}</th>
                        <th>{{number_format($classForwarded['GLIDER'], 1) }}</th>
                        <th>{{number_format($classForwarded['PCATO'], 1) }}</th>
                        <th>{{ $amountForwarded['land_d'] }}</th>
                        <th> {{$amountForwarded['land_n'] }}</th>
                    </tr>
                    <tr>
                        <th colspan="2">TOTALS TO DATE</th>
                        <th>{{ number_format($totalsToDate['total'], 1) }}</th>
                        <th>{{number_format($classTotals['ASEL'], 1) }}</th>
                        <th>{{number_format($classTotals['ASES'], 1) }}</th>
                        <th>{{number_format($classTotals['AMEL'], 1) }}</th>
                        <th>{{number_format($classTotals['AMES'], 1) }}</th>
                        <th>{{number_format($classTotals['JET'], 1) }}</th>
                        <th>{{number_format($classTotals['HELI'], 1) }}</th>
                        <th>{{number_format($classTotals['GLIDER'], 1) }}</th>
                        <th>{{number_format($classTotals['PCATO'], 1) }}</th>
                        <th>{{ $totalsToDate['land_d'] }}</th>
                        <th> {{$totalsToDate['land_n'] }}</th>
                    </tr>
                </tfoot>
            </table>
            <p></p>
            <br>

            <table>
                <thead>
                    <tr>
                        <th colspan="4">CONDITIONS OF FLIGHT</th>
                        <th rowspan="2">FLIGHT SIMULATOR</th>
                        <th colspan="6">TYPE OF PILOTING TIME</th>
                        <th rowspan="2">REMARKS</th>
                        <th colspan="3">INSTRUCTOR ENDORSEMENTS</th>
                    </tr>
                    <tr>
                        <th># APP</th>
                        <th>NIGHT</th>
                        <th>ACTUAL INSTR.</th>
                        <th>SIMULATED INST.</th>

                        <th>XC</th>
                        <th>SOLO</th>
                        <th>PIC</th>
                        <th>SIC</th>
                        <th>DUAL Recv.</th>
                        <th>CFI.</th>

                        <th>NAME</th>
                        <th>OK</th>
                        <th>SIGN.</th>       
                    </tr>                 
                </thead>
                <tbody>
                    @foreach($chunk as $entry)
                    <tr>
                        <td>{{ $entry->approaches }}</td>
                        <td>{{ number_format($entry->night_time, 1) }}</td>
                        <td>{{ number_format($entry->instr_actual, 1) }}</td>
                        <td>{{ number_format($entry->instr_sim, 1) }}</td>

                        <td>{{ number_format($entry->simulated_time, 1) }}</td>
                        
                        <td>{{ number_format($entry->xc_time, 1) }}</td>
                        <td>{{ number_format($entry->solo_time, 1) }}</td>
                        <td>{{ number_format($entry->pic_time, 1) }}</td>
                        <td>{{ number_format($entry->sic_time, 1) }}</td>
                        <td>{{ number_format($entry->dual_time, 1) }}</td>
                        <td>{{ number_format($entry->cfi_time, 1) }}</td> 
                        
                        <td>{{ Str::limit($entry->remarks, 60) }}</td>

                        <td>{{ isset($entry->instructor_id) ? $entry->instructor->name : "" }} </td>
                        <td>
                            {{ (isset($entry->instructor_id))? (($entry->validated && $entry->instructor_id)  ? 'VALIDADO' : 'NO VALIDADO') : 'N/A' }}
                        </td>
                        <td></td>
                    </tr>                    
                    @endforeach
                    
                    @for($i = count($chunk); $i < 8; $i++)
                        <tr>
                            @for($j=0; $j<= 14; $j++)
                                <td>&nbsp;</td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <th>{{ number_format($pageTotals['app'], 1) }}</th>
                        <th>{{ number_format($pageTotals['night'], 1) }}</th>
                        <th>{{ number_format($pageTotals['instr'], 1) }}</th>
                        <th>{{ number_format($pageTotals['instr_sim'], 1) }}</th>

                        <th>{{ number_format($pageTotals['sim_time'], 1) }}</th>

                        <th>{{ number_format($pageTotals['xc'], 1) }}</th>
                        <th>{{ number_format($pageTotals['solo'], 1) }}</th>
                        <th>{{ number_format($pageTotals['pic'], 1) }}</th>
                        <th>{{ number_format($pageTotals['sic'], 1) }}</th>
                        <th>{{ number_format($pageTotals['dual'], 1) }}</th>
                        <th>{{ number_format($pageTotals['cfi'], 1) }}</th>

                        <th colspan="4" rowspan="3"> &nbsp; </th>
                    </tr>
                    <tr>
                        <th>{{ number_format($amountForwarded['app'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['night'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['instr'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['instr_sim'], 1) }}</th>

                        <th>{{ number_format($amountForwarded['sim_time'], 1) }}</th>

                        <th>{{ number_format($amountForwarded['xc'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['solo'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['pic'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['sic'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['dual'], 1) }}</th>
                        <th>{{ number_format($amountForwarded['cfi'], 1) }}</th>
                    </tr>
                    <tr>
                        <th>{{ number_format($totalsToDate['app'], 1) }}</th></th>
                        <th>{{ number_format($totalsToDate['night'], 1) }}</th>
                        <th>{{ number_format($totalsToDate['instr'], 1) }}</th>
                        <th>{{ number_format($totalsToDate['instr_sim'], 1) }}</th>

                        <th>{{ number_format($totalsToDate['sim_time'], 1) }}</th> 

                        <th>{{ number_format($totalsToDate['xc'], 1) }}</th>
                        <th>{{ number_format($totalsToDate['solo'], 1) }}</th>
                        <th>{{ number_format($totalsToDate['pic'], 1) }}</th>
                        <th>{{ number_format($totalsToDate['sic'], 1) }}</th>
                        <th>{{ number_format($totalsToDate['dual'], 1) }}</th>
                        <th>{{ number_format($totalsToDate['cfi'], 1) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach
</body>
</html>
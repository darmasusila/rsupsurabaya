<x-filament-panels::page>
<style>
    /* Custom styles for the laporan pelatihan page */
    .laporan-pelatihan {
        /* Add your styles here */
        data {font-family: Verdana;}
        table.pvtTable {
            font-family: Arial;
            font-size: 1em;
        }
    }
</style>
<link href="{{ asset('webdatarocks/webdatarocks.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" type="text/css"
href="https://cdn.webdatarocks.com/latest/theme/lightblue/webdatarocks.css" />
<script src="{{ asset('webdatarocks/webdatarocks.toolbar.js')}}"></script>
<script src="{{ asset('webdatarocks/webdatarocks.js')}}"></script>
<script src="{{ asset('plugins/jszip/jszip.js') }}"></script>

<div class="laporan-pelatihan">
    <h1 class="text-2xl font-bold mb-4">Laporan Rekap Pelatihan</h1>

    <div id="webdatarocks-container" style="height: 600px;"></div>

    <script>
        function exportData(type) {
            webdatarocks.exportTo(
                type,
                {
                    filename: "laporan_pelatihan",
                    showConfirmDialog: false
                }
            );
        }

        var pivot = new WebDataRocks({
            container: "#webdatarocks-container",
            toolbar: true,
            report: {
                dataSource: {
                    dataSourceType: "json",
                    data: @json($data),
                },
                slice: {
                    rows: [
                        { uniqueName: "jenis_tenaga" }, 
                        { uniqueName: "unit" },
                        { uniqueName: "diklat_jenis" },
                    ],
                    columns: [{ uniqueName: "status_kepegawaian" }],
                    measures: [{ uniqueName: "id", aggregation: "count" }],
                },
            },
        });
    </script>
</x-filament-panels::page>

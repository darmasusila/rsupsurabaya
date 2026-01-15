<x-filament-panels::page>
<style>
    /* Custom styles for the laporan pegawai page */
    .laporan-pegawai {
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

<div class="laporan-pegawai">
    <h1 class="text-2xl font-bold mb-4">Laporan Rekap Pegawai</h1>

    <div id="webdatarocks-container" style="height: 600px;"></div>

    <script>
        function exportData(type) {
            webdatarocks.exportTo(
                type,
                {
                    filename: "laporan_pegawai",
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
                        // { uniqueName: "fungsional" },
                        { uniqueName: "unit" },
                        { uniqueName: "nama" }
                    ],
                    columns: [{ uniqueName: "status_kepegawaian" }],
                    measures: [{ uniqueName: "id", aggregation: "count" }],
                },
            },
        });
    </script>
</x-filament-panels::page>

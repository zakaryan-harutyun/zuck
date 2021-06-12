
<style>
    * {
        font-size: x-small;
    }

    th {
        background-color: #f7f7f7;
        border-color: #959594;
        border-style: solid;
        border-width: 1px;
        text-align: center;
    }

    .bordered td {
        border-color: #959594;
        border-style: solid;
        border-width: 1px;
    }

    table {
        border-collapse: collapse;
    }

    /* Para sobrescribir lo que está en div-table.css */
    .divTableCell,
    .divTableHead {
        padding: 0px !important;
        border: 0px !important;
    }
</style>

<div class="divTable">
    <div class="divTableBody">
        <div class="divTableRow">

            <div class="divTableCell">
                <table class="bordered width-100pc" width="100%">
                    <tr>
                        <th colspan="2">FECHA Y HORA DE EVIDENCIA</th>
                    </tr>
                    <tr>
                        <td class="text-center" width="50%">
                            DÍA - MES - AÑO
                        </td>
                        <td class="text-center" width="50%">
                            HORA: MINUTOS
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            111
                        </td>
                        <td class="text-center">
                           222
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

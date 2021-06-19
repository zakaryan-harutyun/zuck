
<style>
    .divTable{
         background: #feebe1;
     }
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
        padding: 5px;
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
<body>
<div class="divTable">
    <div class="divTableBody">
        <div class="divTableRow">

            <div class="divTableCell">
                <table class="bordered width-100pc" width="100%">
                    @foreach($data as $key => $item)
                        <tr>
                            <td class="text-center" width="50%">
                                {{$item['key'] ? $item['key'] : ''}}
                            </td>
                            <td class="text-center" width="50%">
                                {{$item['value'] ? $item['value'] : ''}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</body>

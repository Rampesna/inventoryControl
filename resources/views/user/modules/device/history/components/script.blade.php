<script src="{{ asset('assets/jqwidgets/jqxcore.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxbuttons.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxscrollbar.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxlistbox.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdropdownlist.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxmenu.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.selection.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.columnsreorder.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.columnsresize.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.filter.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.sort.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdata.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.pager.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxnumberinput.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxwindow.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdata.export.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.export.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxexport.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.grouping.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/globalization/globalize.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqgrid-localization.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jszip.min.js') }}"></script>

<script>

    var deviceId = atob('{{ $encodedId }}');

    var gridDiv = $("#historyGrid");

    $(document).ready(function () {
        $('#loader').hide();
    });

    function getDeviceHistory() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.deviceActivity.getByDeviceId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                deviceId: deviceId,
            },
            success: function (response) {
                console.log(response);

                var dataForJqxGrid = [];
                $.each(response.response, function (i, deviceActivity) {
                    dataForJqxGrid.push({
                        user: deviceActivity.user.name,
                        created_at: reformatDatetimeToDatetimeForHuman(deviceActivity.created_at),
                        type_name: deviceActivity.type.name,
                        relation_name: deviceActivity.relation.name,
                    });
                });

                var source = {
                    localdata: dataForJqxGrid,
                    datatype: "array",
                    datafields: [
                        {name: 'user', type: 'string'},
                        {name: 'created_at', type: 'string'},
                        {name: 'type_name', type: 'string'},
                        {name: 'relation_name', type: 'string'},
                    ]
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                gridDiv.jqxGrid({
                    width: '100%',
                    height: '500',
                    source: dataAdapter,
                    columnsresize: true,
                    groupable: true,
                    theme: jqxGridGlobalTheme,
                    filterable: true,
                    showfilterrow: true,
                    localization: getLocalization('tr'),
                    columns: [
                        {
                            text: 'İşlemi Yapan',
                            dataField: 'user',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'İşlem Tarihi',
                            dataField: 'created_at',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'İşlem',
                            dataField: 'type_name',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'İşlem Durumu',
                            dataField: 'relation_name',
                            columntype: 'textbox',
                        }
                    ]
                });
                gridDiv.on('contextmenu', function () {
                    return false;
                });
                gridDiv.on('rowclick', function (event) {
                    if (event.args.rightclick) {
                        $("#employeesGrid").jqxGrid('selectrow', event.args.rowindex);
                        var scrollTop = $(window).scrollTop();
                        var scrollLeft = $(window).scrollLeft();
                        contextMenu.jqxMenu('open', parseInt(event.args.originalEvent.clientX) + 5 + scrollLeft, parseInt(event.args.originalEvent.clientY) + 5 + scrollTop);
                        return false;
                    }
                });

                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihaz Verileri Alınırken Serviste Bir Sorun Oluştu!');
                $('#loader').hide();
            }
        });
    }

    getDeviceHistory();

</script>

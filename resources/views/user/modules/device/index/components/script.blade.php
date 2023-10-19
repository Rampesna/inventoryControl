<script src="{{ asset('assets/plugins/custom/qrcode/creator.js') }}"></script>

<script>

    var updatePermission = `true`;
    var deletePermission = `true`;

    var devices = $('#devices');

    var qrPrinterDiv = $('#qrPrinter');

    var page = $('#page');
    var pageUpButton = $('#pageUp');
    var pageDownButton = $('#pageDown');
    var pageSizeSelector = $('#pageSize');

    var keywordFilter = $('#keyword');
    var categoryIdsFilter = $('#categoryIds');
    var statusIdsFilter = $('#statusIds');

    var FilterButton = $('#FilterButton');
    var ClearFilterButton = $('#ClearFilterButton');
    var CreateDeviceButton = $('#CreateDeviceButton');
    var UpdateDeviceButton = $('#UpdateDeviceButton');
    var DeleteDeviceButton = $('#DeleteDeviceButton');

    var createDeviceCategoryId = $('#create_device_category_id');
    var createDeviceStatusId = $('#create_device_status_id');
    var createDevicePackageId = $('#create_device_package_id');
    var createDeviceEmployeeId = $('#create_device_employee_id');

    var updateDeviceCategoryId = $('#update_device_category_id');
    var updateDeviceStatusId = $('#update_device_status_id');
    var updateDevicePackageId = $('#update_device_package_id');
    var updateDeviceEmployeeId = $('#update_device_employee_id');

    function createDevice() {
        createDeviceEmployeeId.val('');
        createDeviceCategoryId.val('');
        createDeviceStatusId.val('');
        $('#create_device_name').val('');
        $('#create_device_brand').val('');
        $('#create_device_model').val('');
        $('#create_device_serial_number').val('');
        $('#create_device_ip_address').val('');
        $('#create_device_description').val('');
        $('#CreateDeviceModal').modal('show');
    }

    function createQrForDevice(deviceId) {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.device.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: deviceId
            },
            success: function (response) {
                $('#DeviceQrModal').modal('show');
                $('#qrcode').empty().qrcode(deviceId.toString());
                $('#qr_device_name').text(`${response.response.name}${response.response.package ? ` - ${response.response.package.name}` : ``}`);
                $('#qr_device_serial').text(response.response.serial_number);
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihazlar Bilgisi Alınırken Serviste Bir Sorun Oluştu.');
                $('#loader').hide();
            }
        });
    }

    function history(id) {
        var base64EncodedId = btoa(id);
        window.open('{{ route('user.web.inventory.device.history') }}/' + base64EncodedId, '_blank');
    }

    function updateDevice(id) {
        $('#loader').show();
        $('#update_device_id').val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.device.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                updateDeviceEmployeeId.val(response.response.employee_id);
                updateDeviceCategoryId.val(response.response.category_id);
                updateDeviceStatusId.val(response.response.status_id);
                $('#update_device_name').val(response.response.name);
                $('#update_device_brand').val(response.response.brand);
                $('#update_device_model').val(response.response.model);
                $('#update_device_serial_number').val(response.response.serial_number);
                $('#update_device_ip_address').val(response.response.ip_address);
                $('#update_device_description').val(response.response.description);
                $('#UpdateDeviceModal').modal('show');
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihaz Verileri Alınırken Serviste Bir Sorun Oluştu!');
                $('#loader').hide();
            }
        });
    }

    function deleteDevice(id) {
        $('#delete_device_id').val(id);
        $('#DeleteDeviceModal').modal('show');
    }

    function getEmployees() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.employee.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                companyIds: SelectedCompanies.val(),
                pageIndex: 0,
                pageSize: 1000,
                leave: 0,
            },
            success: function (response) {
                createDeviceEmployeeId.empty();
                updateDeviceEmployeeId.empty();
                createDeviceEmployeeId.append($('<option>', {
                    value: 0,
                    text: '- Personel Yok -'
                }));
                updateDeviceEmployeeId.append($('<option>', {
                    value: 0,
                    text: '- Personel Yok -'
                }));
                $.each(response.response, function (i, employee) {
                    createDeviceEmployeeId.append($('<option>', {
                        value: employee.id,
                        text: employee.name
                    }));
                    updateDeviceEmployeeId.append($('<option>', {
                        value: employee.id,
                        text: employee.name
                    }));
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Personeller Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function getDeviceCategories() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.deviceCategory.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                categoryIdsFilter.empty();
                createDeviceCategoryId.empty();
                updateDeviceCategoryId.empty();
                $.each(response.response, function (i, deviceCategory) {
                    categoryIdsFilter.append($('<option>', {
                        value: deviceCategory.id,
                        text: deviceCategory.name
                    }));
                    createDeviceCategoryId.append($('<option>', {
                        value: deviceCategory.id,
                        text: deviceCategory.name
                    }));
                    updateDeviceCategoryId.append($('<option>', {
                        value: deviceCategory.id,
                        text: deviceCategory.name
                    }));
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihaz Durumları Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function getDeviceStatuses() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.deviceStatus.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                statusIdsFilter.empty();
                createDeviceStatusId.empty();
                updateDeviceStatusId.empty();
                $.each(response.response, function (i, deviceStatus) {
                    statusIdsFilter.append($('<option>', {
                        value: deviceStatus.id,
                        text: deviceStatus.name
                    }));
                    createDeviceStatusId.append($('<option>', {
                        value: deviceStatus.id,
                        text: deviceStatus.name
                    }));
                    updateDeviceStatusId.append($('<option>', {
                        value: deviceStatus.id,
                        text: deviceStatus.name
                    }));
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihaz Kategorileri Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function getDevicePackages() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.devicePackage.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {},
            success: function (response) {
                createDevicePackageId.empty();
                updateDevicePackageId.empty();
                createDevicePackageId.append($('<option>', {
                    value: 0,
                    text: '- Grup Yok -'
                }));
                updateDevicePackageId.append($('<option>', {
                    value: 0,
                    text: '- Grup Yok -'
                }));
                $.each(response.response, function (i, devicePackage) {
                    createDevicePackageId.append($('<option>', {
                        value: devicePackage.id,
                        text: devicePackage.name
                    }));
                    updateDevicePackageId.append($('<option>', {
                        value: devicePackage.id,
                        text: devicePackage.name
                    }));
                });
                createDevicePackageId.val('').trigger('change');
                updateDevicePackageId.val('').trigger('change');
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihaz Grupları Alınırken Serviste Bir Sorun Oluştu!');
            }
        });
    }

    function getDevices() {
        $('#loader').show();
        var pageIndex = parseInt(page.html()) - 1;
        var pageSize = pageSizeSelector.val();
        var keyword = keywordFilter.val();
        var categoryIds = categoryIdsFilter.val();
        var statusIds = statusIdsFilter.val();

        $.ajax({
            type: 'get',
            url: '{{ route('user.api.device.index') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                pageIndex: pageIndex,
                pageSize: pageSize,
                keyword: keyword,
                categoryIds: categoryIds,
                statusIds: statusIds,
            },
            success: function (response) {
                devices.empty();
                $('#totalCountSpan').text(response.response.totalCount);
                $('#startCountSpan').text(parseInt(((pageIndex) * pageSize)) + 1);
                $('#endCountSpan').text(parseInt(parseInt(((pageIndex) * pageSize)) + 1) + parseInt(pageSize) > response.response.totalCount ? response.response.totalCount : parseInt(((pageIndex) * pageSize)) + 1 + parseInt(pageSize));
                $.each(response.response.devices, function (i, device) {
                    devices.a12345ppend(`
                    <tr>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-icon btn-sm" type="button" id="${device.id}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="${device.id}_Dropdown" style="width: 175px">
                                    ${updatePermission === 'true' ? `
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="updateDevice(${device.id})" title="Düzenle"><i class="fas fa-edit me-2 text-primary"></i> <span class="text-dark">Düzenle</span></a>
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="createQrForDevice(${device.id})" title="QR Kod"><i class="fas fa-qrcode me-2 text-dark"></i> <span class="text-dark">QR Kod</span></a>
                                    ` : ``}
                                    ${deletePermission === 'true' ? `
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="history(${device.id})" title="QR Kod"><i class="fas fa-history me-2 text-info"></i> <span class="text-info">İşlem Geçmişi</span></a>
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deleteDevice(${device.id})" title="Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Sil</span></a>
                                    ` : ``}
                                </div>
                            </div>
                        </td>
                        <td>
                            ${device.name ?? ''}
                        </td>
                        <td>
                            ${device.employee ? device.employee.name : ''}
                        </td>
                        <td>
                            <span class="badge badge-${device.status ? device.status.color : 'secondary'}">${device.status ? device.status.name : ''}</span>
                        </td>
                        <td>
                            ${device.package ? device.package.name : ''}
                        </td>
                        <td>
                            ${device.category ? device.category.name : ''}
                        </td>
                        <td>
                            ${device.serial_number ?? ''}
                        </td>
                        <td>
                            ${device.brand ?? ''}
                        </td>
                        <td>
                            ${device.model ?? ''}
                        </td>
                        <td>
                            ${device.ip_address ?? ''}
                        </td>
                        <td>
                            ${device.description ?? ''}
                        </td>
                    </tr>
                    `);
                });

                if (response.response.totalCount <= (pageIndex + 1) * pageSize) {
                    pageUpButton.attr('disabled', true);
                } else {
                    pageUpButton.attr('disabled', false);
                }

                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihazlar Alınırken Serviste Bir Sorun Oluştu.');
                $('#loader').hide();
            }
        });
    }

    getEmployees();
    getDeviceCategories();
    getDeviceStatuses();
    getDevicePackages();
    getDevices();

    keywordFilter.on('keypress', function (e) {
        if (e.which === 13) {
            changePage(1);
        }
    });

    function changePage(newPage) {
        if (newPage === 1) {
            pageDownButton.attr('disabled', true);
        } else {
            pageDownButton.attr('disabled', false);
        }

        page.html(newPage);
        getDevices();
    }

    pageUpButton.click(function () {
        changePage(parseInt(page.html()) + 1);
    });

    pageDownButton.click(function () {
        changePage(parseInt(page.html()) - 1);
    });

    pageSizeSelector.change(function () {
        changePage(1);
    });

    FilterButton.click(function () {
        changePage(1);
    });

    ClearFilterButton.click(function () {
        keywordFilter.val('');
        categoryIdsFilter.val([]).trigger('change');
        statusIdsFilter.val([]).trigger('change');
        changePage(1);
    });

    CreateDeviceButton.click(function () {
        var employeeId = createDeviceEmployeeId.val();
        var categoryId = createDeviceCategoryId.val();
        var statusId = createDeviceStatusId.val();
        var packageId = createDevicePackageId.val();
        var name = $('#create_device_name').val();
        var brand = $('#create_device_brand').val();
        var model = $('#create_device_model').val();
        var serialNumber = $('#create_device_serial_number').val();
        var ipAddress = $('#create_device_ip_address').val();
        var description = $('#create_device_description').val();

        if (!categoryId) {
            toastr.warning('Kategori Seçimi Zorunludur!');
        } else if (!statusId) {
            toastr.warning('Durum Seçimi Zorunludur!');
        } else if (!name) {
            toastr.warning('Cihaz Adı Zorunludur!');
        } else {
            CreateDeviceButton.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.device.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    employeeId: parseInt(employeeId) === 0 ? null : employeeId,
                    categoryId: categoryId,
                    statusId: statusId,
                    packageId: packageId,
                    name: name,
                    brand: brand,
                    model: model,
                    serialNumber: serialNumber,
                    ipAddress: ipAddress,
                    description: description,
                },
                success: function () {
                    toastr.success('Cihaz Başarıyla Oluşturuldu!');
                    changePage(1);
                    CreateDeviceButton.attr('disabled', false).html('Oluştur');
                    $('#CreateDeviceModal').modal('hide');
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Cihaz Oluşturulurken Serviste Bir Sorun Oluştu!');
                    CreateDeviceButton.attr('disabled', false).html('Oluştur');
                }
            });
        }
    });

    UpdateDeviceButton.click(function () {
        var id = $('#update_device_id').val();
        var employeeId = updateDeviceEmployeeId.val();
        var categoryId = updateDeviceCategoryId.val();
        var statusId = updateDeviceStatusId.val();
        var packageId = updateDevicePackageId.val();
        var name = $('#update_device_name').val();
        var brand = $('#update_device_brand').val();
        var model = $('#update_device_model').val();
        var serialNumber = $('#update_device_serial_number').val();
        var ipAddress = $('#update_device_ip_address').val();
        var description = $('#update_device_description').val();

        if (!categoryId) {
            toastr.warning('Kategori Seçimi Zorunludur!');
        } else if (!statusId) {
            toastr.warning('Durum Seçimi Zorunludur!');
        } else if (!name) {
            toastr.warning('Cihaz Adı Zorunludur!');
        } else {
            UpdateDeviceButton.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.device.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    id: id,
                    employeeId: parseInt(employeeId) === 0 ? null : employeeId,
                    categoryId: categoryId,
                    statusId: statusId,
                    packageId: packageId,
                    name: name,
                    brand: brand,
                    model: model,
                    serialNumber: serialNumber,
                    ipAddress: ipAddress,
                    description: description,
                },
                success: function () {
                    toastr.success('Cihaz Başarıyla Güncellendi!');
                    changePage(parseInt(page.html()));
                    UpdateDeviceButton.attr('disabled', false).html('Güncelle');
                    $('#UpdateDeviceModal').modal('hide');
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Cihaz Güncellenirken Serviste Bir Sorun Oluştu!');
                    UpdateDeviceButton.attr('disabled', false).html('Güncelle');
                }
            });
        }
    });

    DeleteDeviceButton.click(function () {
        var id = $('#delete_device_id').val();
        DeleteDeviceButton.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.device.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function () {
                toastr.success('Cihaz Başarıyla Silindi!');
                changePage(parseInt(page.html()));
                DeleteDeviceButton.attr('disabled', false).html('Sil');
                $('#DeleteDeviceModal').modal('hide');
            },
            error: function (error) {
                console.log(error);
                toastr.error('Cihaz Silinirken Serviste Bir Sorun Oluştu!');
                DeleteDeviceButton.attr('disabled', false).html('Sil');
            }
        });
    });

    $(document).delegate('.deviceCreateInput', 'keypress', function (e) {
        if (e.which === 13) {
            CreateDeviceButton.click();
        }
    });

    $(document).delegate('.deviceUpdateInput', 'keypress', function (e) {
        if (e.which === 13) {
            UpdateDeviceButton.click();
        }
    });

</script>

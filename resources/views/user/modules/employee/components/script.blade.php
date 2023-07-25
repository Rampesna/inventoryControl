<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var employeesRow = $('#employees');

    var keyword = $('#keyword');

    function getEmployeesWithDevices() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.employee.getAllWithDevices') }}',
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
                employeesRow.empty();
                $.each(response.response, function (i, employee) {
                    var devices = ``;
                    if (employee.devices.length > 0) {
                        $.each(employee.devices, function (j, device) {
                            devices += `
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-50px w-7px bg-${device.status ? device.status.color : 'secondary'} me-4"></span>
                                    <div class="flex-grow-1">
                                        <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6 deviceNameSearch">${device.name}</a>
                                        <span class="text-muted fw-bold d-block deviceStatusSearch">Durum: ${device.status ? device.status.name : '--'}</span>
                                        <span class="text-muted fw-bold d-block deviceCategorySearch">Kategori: ${device.category ? device.category.name : '--'}</span>
                                        <span class="text-muted fw-bold d-block deviceBrandSearch">Marka: ${device.brand ?? '--'}</span>
                                        <span class="text-muted fw-bold d-block deviceModelSearch">Model: ${device.model ?? '--'}</span>
                                        <span class="text-muted fw-bold d-block deviceSerialSearch">Seri No: ${device.serial_number ?? '--'}</span>
                                        <span class="text-muted fw-bold d-block deviceIpSearch">IP: ${device.ip_address ?? '--'}</span>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        devices = `<p class="text-center fw-bolder">Hiç Cihaz Yok</p>`;
                    }
                    employeesRow.append(`
                    <div class="col-xl-3 col-sm-6 col-12 employeeCard" id="${employee.id}_employeeCard" data-id="${employee.id}" data-guid="${employee.guid}" data-name="${employee.name}" data-job-department="${employee.job_department ? employee.job_department.id : 0}">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-body">
                                <div class="mb-5 text-center">
                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1 toggleEmployeeDevices" data-employee-id="${employee.id}">${employee.name}</a>
                                </div>
                                <div class="separator separator-dashed my-5"></div>
                                <div id="employee${employee.id}Devices" style="display: none">
                                    ${devices}
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Personel Listesi Alınırken Sistemsel Bir Sorun Oluştu!');
            }
        });
    }

    function filterEmployees() {
        var employees = $('.employeeCard');
        $.each(employees, function (i, employeeCard) {
            var employeeName = $(employeeCard).data('name');
            var deviceName = $(employeeCard).find('.deviceNameSearch').text();
            var deviceStatus = $(employeeCard).find('.deviceStatusSearch').text();
            var deviceCategory = $(employeeCard).find('.deviceCategorySearch').text();
            var deviceBrand = $(employeeCard).find('.deviceBrandSearch').text();
            var deviceModel = $(employeeCard).find('.deviceModelSearch').text();
            var deviceSerial = $(employeeCard).find('.deviceSerialSearch').text();
            var deviceIp = $(employeeCard).find('.deviceIpSearch').text();

            if (
                employeeName.toLowerCase().includes(keyword.val().toLowerCase()) ||
                deviceName.toLowerCase().includes(keyword.val().toLowerCase()) ||
                deviceStatus.toLowerCase().includes(keyword.val().toLowerCase()) ||
                deviceCategory.toLowerCase().includes(keyword.val().toLowerCase()) ||
                deviceBrand.toLowerCase().includes(keyword.val().toLowerCase()) ||
                deviceModel.toLowerCase().includes(keyword.val().toLowerCase()) ||
                deviceSerial.toLowerCase().includes(keyword.val().toLowerCase()) ||
                deviceIp.toLowerCase().includes(keyword.val().toLowerCase())
            ) {
                $(this).removeClass('d-none');
            } else {
                $(this).addClass('d-none');
            }
        });
    }

    getEmployeesWithDevices();

    $(document).delegate('.toggleEmployeeDevices', 'click', function () {
        $(`#employee${$(this).data('employee-id')}Devices`).slideToggle();
    });

    keyword.keyup(function () {
        filterEmployees();
    });

</script>

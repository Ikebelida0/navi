var invoiceDetails = [];

$(document).ready(function () {

    $('#searchButton').on('click', function (event) {
        event.preventDefault();
        var documentNumber = $('#documentNumberInput').val();
        fetchAndDisplayInvoiceDetails(documentNumber);
    });

    $('#documentNumberInput').on('keydown', function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            var documentNumber = $(this).val();
            fetchAndDisplayInvoiceDetails(documentNumber);
        }
    });

    $('#documentNumbersBody').on('click', '.view-btn', function () {
        var documentNumber = $(this).data('id');
        fetchAndDisplayInvoiceDetails(documentNumber);
        $('#invoiceModal').modal('show');
    });

    var lastFetchedDocumentNumber = '';
    var tinNumber = '';

    function fetchAndDisplayInvoiceDetails(documentNumber) {

        if (documentNumber.trim() === '') {
           Swal.fire({
            icon: 'error',
            title: 'Please enter a valid document number.',
            animation: true,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            
        });
            return;
        }
        var progressBar = '<div class="progress"><div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar">0%</div></div>';

        $('#documentNumbersBody').html(progressBar);
        var progressValue = 0;
        var progressInterval = setInterval(function () {
            progressValue += 10;
            $('.progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue).text(progressValue + '%');
            if (progressValue >= 100) {
                clearInterval(progressInterval);

                setTimeout(function () {
                    $('#documentNumbersBody .progress').remove();
                }, 1000);
            }
        }, 100);

        setTimeout(function () {
            $.ajax({
                url: '/getInvoiceDetails',
                method: 'GET',
                data: { documentNumber: documentNumber },
                beforeSend: function () {
                    $('.progress').remove();
                    progressValue = 0;
                },
                complete: function () {
                    $('#documentNumbersBody .progress').remove();
                },
                success: function (data) {
                    invoiceDetails = data.invoiceDetails;
                    if (data.invoiceDetails.length > 0) {
                        displayInvoiceNumber(data.invoiceDetails, documentNumber);

                        $('#invoiceNo').html('<strong>Sales Invoice</strong>: ' + documentNumber);

                        if (documentNumber !== lastFetchedDocumentNumber) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success, Data Fetched Successfully.',
                                animation: true,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                            });
                        }
                        updateTableAndPagination();
                        lastFetchedDocumentNumber = documentNumber;

                        generatePDF(data.invoiceDetails, tinNumber);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Please enter a valid document number.',
                            animation: true,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                    }
                },
            });
        }, 2000);
    }

    var currentPage = 1;
    var itemsPerPage = 6; // Number of items to display per page

    $('#prevPage').on('click', function (event) {
        event.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            updateTableAndPagination();
        }
    });

    $('#nextPage').on('click', function (event) {
        event.preventDefault();
        var totalPages = Math.ceil(invoiceDetails.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updateTableAndPagination();
        }
    });


    function updateTableAndPagination() {

        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;
        var visibleData = invoiceDetails.slice(startIndex, endIndex);

        var tableBody = $('#invoiceModalBody');
        tableBody.empty();
        for (var i = 0; i < visibleData.length; i++) {
            var item = visibleData[i];
            var row = '<tr>' +
                '<td>' + item.qty + '</td>' +
                '<td>' + item.uom + '</td>' +
                '<td>' + item.No + '</td>' +
                '<td>' + item.esc + '</td>' +
                '<td>' + item.lot_no + '</td>' +
                '<td>' + item.exp_date + '</td>' +
                '<td>' + item.deal + '</td>' +
                '<td>' + item.line_percent + '</td>' +
                '<td>' + '₱' + item.price + '</td>' +
                '<td>' + item.net_price + '</td>' +
                '<td>' + item.lda + '</td>' +
                '<td>' + '₱' + item.amount + '</td>' +
                '</tr>';
            tableBody.append(row);

        }
        updatePaginationInfo();
    }
    function updatePaginationInfo() {
        // var totalPages = Math.ceil(invoiceDetails.length / itemsPerPage);
        var startItem = (currentPage - 1) * itemsPerPage + 1;
        var endItem = Math.min(currentPage * itemsPerPage, invoiceDetails.length);
        var currentPageInfo = 'Showing ' + startItem + ' to ' + endItem + ' of ' + invoiceDetails.length + ' entries';
        $('.pagination-info').text(currentPageInfo);

        $('#currentPage .current-page-number').text(currentPage);
    }


    $('#pdfButton').click(function () {
        var tinNumber = $('#tinNumberInput').val();
        var trimmedTinNumber = tinNumber.trim();
        var documentNumber = $('#documentNumberInput').val();
        if (trimmedTinNumber !== '' && invoiceDetails.length > 0) {
            generatePDF(invoiceDetails, trimmedTinNumber, documentNumber);
        } else {

            Swal.fire({
                title: "Please input TIN number",
                icon: "error",
                animation: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,

            });
        }
    });

    function generatePDF(invoiceDetails, tinNumber, documentNumber) {
        if (tinNumber && invoiceDetails.length > 0) {
            var pdf = new jsPDF();

            pdf.setFontSize(15);
            pdf.text("SALES INVOICE DETAILS", 10, 10);

            pdf.setFontSize(10);
            pdf.text("TIN Number: " + tinNumber, 10, 20);

            pdf.setFontSize(10);
            pdf.text("Document Number: " + documentNumber, 10, 30);

            var tableColumns = ["QTY", "UNIT OF MEASURE", "NO.", "DESCRIPTION", "LOT NO.", "EXP. DATE", "DEAL", "LINE DISCOUNT %", "UNIT PRICE", "NET PRICE", "LINE DISCOUNT AMOUNT", "AMOUNT"];

            var tableData = invoiceDetails.map(item => [
                item.qty,
                item.uom,
                item.No,
                item.esc,
                item.lot_no,
                item.exp_date,
                item.deal,
                item.line_percent,
                item.price,
                item.net_price,
                item.lda,
                item.amount
            ]);

            // Calculate the sum of the "AMOUNT" column
            var sum = tableData.reduce((sum, row) => sum + parseFloat(row[tableColumns.indexOf("AMOUNT")]), 0);

            // Add the total row
            var totalRow = Array(tableColumns.length).fill("");
            totalRow[tableColumns.indexOf("DESCRIPTION")] = "TOTAL AMOUNT :";
            totalRow[tableColumns.indexOf("AMOUNT")] = sum.toFixed(2);
            tableData.push(totalRow);
            pdf.autoTable({
                head: [tableColumns],
                body: tableData,
                startY: 40,
                styles: {
                    fontSize: 6,
                    halign: "center",
                    valign: "middle"
                },
            });

            var pdfDataUri = pdf.output('datauristring');

            var pdfWindow = window.open();
            pdfWindow.document.write('<iframe width="100%" height="100%" src="' + pdfDataUri + '"></iframe>');
        }
    }

    $('#excelButton').click(function () {
        var documentNumber = $('#documentNumberInput').val();
        if (invoiceDetails.length > 0) {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to export this data?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, export it!",
                cancelButtonText: "No, cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    exportToExcel(invoiceDetails, documentNumber);
                }
            });
        } else {
            Swal.fire({
                title: "There is no data to export.",
                icon: "warning",
                animation: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }
    });

    //     function exportToExcel(data, documentNumber) {
    //     function capitalize(str) {
    //         return str.charAt(0).toUpperCase() + str.slice(1);
    //     }

    //     var workbook = XLSX.utils.book_new();
    //     var worksheet = XLSX.utils.json_to_sheet(data, { header: [], skipHeader: true });

    //     var documentRow = {};
    //     documentRow['DocumentNumber'] = documentNumber;
    //     XLSX.utils.sheet_add_json(worksheet, [documentRow], { skipHeader: true, origin: -1 });

    //     // Capitalize headers
    //     var headers = [];
    //     for (var key in data[0]) {
    //         headers.push(capitalize(key));
    //     }
    //     XLSX.utils.sheet_add_aoa(worksheet, [headers], { origin: 0 });

    //     XLSX.utils.book_append_sheet(workbook, worksheet, "InvoiceDetails");

    //     var excelData = XLSX.write(workbook, { bookType: 'xlsx', type: 'base64' });
    //     var dataUri = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,' + excelData;

    //     var downloadLink = document.createElement('a');
    //     downloadLink.href = dataUri;
    //     downloadLink.download = 'Marcela Pharma Distribution Inc.xlsx';
    //     document.body.appendChild(downloadLink);
    //     downloadLink.click();
    //     document.body.removeChild(downloadLink);
    // }


    function displayInvoiceNumber(invoiceDetails, documentNumber) {
        var tableBody = $('#invoiceModalBody');
        tableBody.empty();

        var documentNumbersTable = $('#documentNumbersBody');
        documentNumbersTable.empty();

        var row =
            '<tr>' +
            '<td>' + documentNumber + '</td>' +
            '<td><button class="btn btn-primary btn-sm view-btn" data-id="' + documentNumber + '">View</button></td>' +
            '</tr>';
        documentNumbersTable.append(row);

        for (var i = 0; i < invoiceDetails.length; i++) {
            var item = invoiceDetails[i];
            var row = '<tr>' +
                '<td>' + item.qty + '</td>' +
                '<td>' + item.uom + '</td>' +
                '<td>' + item.No + '</td>' +
                '<td>' + item.esc + '</td>' +
                '<td>' + item.lot_no + '</td>' +
                '<td>' + item.exp_date + '</td>' +
                '<td>' + item.deal + '</td>' +
                '<td>' + item.line_percent + '</td>' +
                '<td>' + '₱' + item.price + '</td>' +
                '<td>' + item.net_price + '</td>' +
                '<td>' + item.lda + '</td>' +
                '<td>' + '₱' + item.amount + '</td>' +
                '</tr>';

            tableBody.append(row);
        }
        tableBody.find('.spinner-border').parent().parent().remove();
    }

    $('#searchForm').on('submit', function (event) {
        event.preventDefault();
        var searchTerm = $('input[name="searchTerm"]').val().toLowerCase();
        applyFilters(searchTerm);
    });

    // $('input[name="searchTerm"]').on('input', function () {
    //     var searchTerm = $(this).val().toLowerCase();
    //     applyFilters(searchTerm);
    // });

    function applyFilters(searchTerm) {
        var tableBody = $('#invoiceModalBody');
        tableBody.empty();


        if (searchTerm.trim() === "") {
            $('input[name="searchTerm"]').val("");

            updateTableAndPagination();
            return;
        }

        var matchingRowsExist = false;

        for (var i = 0; i < invoiceDetails.length; i++) {
            var item = invoiceDetails[i];
            if (
                item.qty.toLowerCase().includes(searchTerm) ||
                item.uom.toLowerCase().includes(searchTerm) ||
                item.No.toLowerCase().includes(searchTerm) ||
                item.esc.toLowerCase().includes(searchTerm) ||
                item.lot_no.toLowerCase().includes(searchTerm) ||
                item.exp_date.toLowerCase().includes(searchTerm) ||
                item.deal.toLowerCase().includes(searchTerm) ||
                item.line_percent.toLowerCase().includes(searchTerm) ||
                item.price.toLowerCase().includes(searchTerm) ||
                item.net_price.toLowerCase().includes(searchTerm) ||
                item.lda.toLowerCase().includes(searchTerm) ||
                item.amount.toLowerCase().includes(searchTerm)
            ) {
                matchingRowsExist = true;
                var row = '<tr>' +
                    '<td>' + item.qty + '</td>' +
                    '<td>' + item.uom + '</td>' +
                    '<td>' + item.No + '</td>' +
                    '<td>' + item.esc + '</td>' +
                    '<td>' + item.lot_no + '</td>' +
                    '<td>' + item.exp_date + '</td>' +
                    '<td>' + item.deal + '</td>' +
                    '<td>' + item.line_percent + '</td>' +
                    '<td>' + '₱' + item.price + '</td>' +
                    '<td>' + item.net_price + '</td>' +
                    '<td>' + item.lda + '</td>' +
                    '<td>' + '₱' + item.amount + '</td>' +
                    '</tr>';
                tableBody.append(row);
            }
        }
        if (!matchingRowsExist) {
            Swal.fire({
                title: "No matching data found for the entered search term.",
                icon: "info",
                animation: true,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
            var noDataRow = '<tr><td colspan="12" class="text-center">No Data Available</td></tr>';
            tableBody.append(noDataRow);
        }
    }
});


<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title" id="invoiceModalLabel"><i class="fas fa-solid fa-align-left"></i>  SALES INVOICE DETAILS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: chartreuse;"></button>
            </div>
            <div class="container mt-2">
                <h5 class="modal-title" id="invoiceNo"></h5>
            </div>

            <div class="container mt-3">
                <form id="searchForm">
                    <div class="input-group mb-1" style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="flex: 1;">
                            <div class="input-group" style="max-width: 300px;">
                                <input type="search" class="form-control" name="searchTerm" placeholder="Search Data" aria-label="Search Data" aria-describedby="searchButton">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center shadow">
                        <thead>
                            <tr>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">QTY</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">UNIT OF MEASURE</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">NO.</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">DESCRIPTION</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">EXP. DATE</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">LINE DISCOUNT %</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">UNIT PRICE</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">NET PRICE</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">LINE DISCOUNT AMOUNT</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">AMOUNT</th>
                                <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); ">AMOUNT WITH (VAT)</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceModalBody">
                                <tr>
                                    <td colspan="12" class="text-center">No invoice details available</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div class=" mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pagination-info">
                                {{-- Showing ( 0 to 0 ) of (0) entries --}}
                            </div>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item" id="prevPage">
                                        <a class="page-link bg-primary text-light" href="#" aria-label="Previous">
                                            <span aria-hidden="true">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item" id="currentPage">
                                        <a class="page-link" href="#">
                                            <span class="current-page-number">1</span>
                                        </a>
                                    </li>
                                    <li class="page-item" id="nextPage">
                                         <a class="page-link bg-primary text-light" href="#" aria-label="Next">
                                            <span aria-hidden="true">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="tinNumberInput" placeholder="Enter TIN Number">
                        </div>
                        <div class="col-md-6 text-md-right">
                            <button class="btn btn-sm btn-danger" id="pdfButton">
                                <i class="fas fa-print"></i> Generate Pdf
                            </button>
                            <button type="button" class="btn btn-sm btn-success ml-2" id="excelButton">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@extends('layouts.app')
@section('content')

@include('invoice.modal')

    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="input-group mb-1" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="flex: 1;">
                        <div class="input-group" style="max-width: 400px;">
                            <input type="search" id="documentNumberInput" class="form-control" placeholder="Enter Document Number" aria-label="Document Number" aria-describedby="searchButton">
                            <button class="btn btn-primary" id="searchButton" ><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>

                <div class="progress" id="topProgressBar"></div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center shadow mt-1">
                        <thead>
                            <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); padding: 10px;">DOCUMENT NO.</th>
                            <th style="background-color:rgb(0, 0, 0); text-align: center; color:rgb(0, 255, 13); padding: 10px;">ACTION</th>
                        </thead>
                        <tbody id="documentNumbersBody">

                            <tr>
                                <td colspan="12" class="text-center">No Document Number Available</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection



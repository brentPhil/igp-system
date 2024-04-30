<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body{
            padding-top:50px;
            background-color:#34495e;
        }

        .hiddenRow {
            padding: 0 !important;
        }
    </style>
</head>
<div class="container">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Employee
            </div>
            <div class="panel-body">
                <table class="table table-condensed table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Fist Name</th>
                        <th>Last Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr data-bs-toggle="collapse" data-bs-target="#collapseOne" class="collapsed">
                        <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                        <td>Carlos</td>
                        <td>Mathias</td>
                        <td>Leme</td>
                        <td>SP</td>
                        <td>new</td>
                    </tr>

                    </tbody>
                    <tbody id="collapseOne" class="accordion-collapse collapse accordion-body" data-bs-parent="#accordionExample">

                    <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                        <td> <a href="#">Enginner Software</a></td>
                        <td>Google</td>
                        <td>U$8.00000 </td>
                        <td> 2016/09/27</td>
                        <td> 2017/09/27</td>
                        <td>
                            <a href="#" class="btn btn-default btn-sm">
                                <i class="glyphicon glyphicon-cog"></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="12" class="hiddenRow">
                            <div class="accordian-body collapse" id="demo10">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td><a href="#"> XPTO 1</a></td>
                                        <td>XPTO 2</td>
                                        <td>Obs</td>
                                    </tr>
                                    <tr>
                                        <th>item 1</th>
                                        <th>item 2</th>
                                        <th>item 3 </th>
                                        <th>item 4</th>
                                        <th>item 5</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>item 1</td>
                                        <td>item 2</td>
                                        <td>item 3</td>
                                        <td>item 4</td>
                                        <td>item 5</td>
                                        <td>
                                            <a href="#" class="btn btn-default btn-sm">
                                                <i class="glyphicon glyphicon-cog"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Scrum Master</td>
                        <td>Google</td>
                        <td>U$8.00000 </td>
                        <td> 2016/09/27</td>
                        <td> 2017/09/27</td>
                        <td> <a href="#" class="btn btn-default btn-sm">
                                <i class="glyphicon glyphicon-cog"></i>
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>Back-end</td>
                        <td>Google</td>
                        <td>U$8.00000 </td>
                        <td> 2016/09/27</td>
                        <td> 2017/09/27</td>
                        <td> <a href="#" class="btn btn-default btn-sm">
                                <i class="glyphicon glyphicon-cog"></i>
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>Front-end</td>
                        <td>Google</td>
                        <td>U$8.00000 </td>
                        <td> 2016/09/27</td>
                        <td> 2017/09/27</td>
                        <td> <a href="#" class="btn btn-default btn-sm">
                                <i class="glyphicon glyphicon-cog"></i>
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
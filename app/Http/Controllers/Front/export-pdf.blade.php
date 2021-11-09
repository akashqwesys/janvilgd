<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Laravel 8 PDF </title>
    <! - Bootstrap5 CSS ->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

   <style>
   table, th, td {
  border: 1px solid black;
}
 th, td {
  border-color: #96D4D4;
 
}
.col1{
   width:100px;
}
.col2{
   width:500px;;
}

   </style>
</head>
<body>
    <div class = "container mt-4">
        <div class = "row">
            <div class = "col-md-8">
                <h2> Product list </h2>
            </div>
            <div class = "col-md-4">
                <div class = "mb-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="http://127.0.0.1:8000/product/pdf"> Export to PDF </a>
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-12">
                <table class = "table">
                    <caption> Diamond List </caption>                    
                    <thead>
                      <tr>
                        <th scope = "col" class="col1"> Name </th>  
                        <th scope = "col" class="col1"> Carat </th>
                        <th scope = "col" class="col1"> Price </th>
                        <th scope = "col" class="col1"> Shape </th>
                        <th scope = "col" class="col1"> Cut </th>
                        <th scope = "col" class="col1"> Color </th>
                        <th scope = "col" class="col2"> Clarity </th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($final_d as $row)
                        <tr>
                            <td  class="col1"> {{$row->diamond_name}} </td>
                            <td class="col1" > {{$row->carat}} </td>
                            <td class="col1" > {{$row->price}} </td>                            
                            <td class="col1" > 
                                @php
                                if (isset($row['attributes']['SHAPE'])) {
                                    echo $v['attributes']['SHAPE'];
                                }else{
                                    echo '-';
                                }
                                @endphp
                            </td>
                            <td class="col1" > 
                                @php
                                if (isset($row['attributes']['CUT GRADE'])) {
                                    echo $v['attributes']['CUT GRADE'];
                                }else{
                                    echo '-';
                                }
                                @endphp
                            </td>
                            <td class="col1" > 
                                @php
                                if (isset($row['attributes']['COLOR'])) {
                                    echo $v['attributes'][COLOR'];
                                }else{
                                    echo '-';
                                }
                                @endphp
                            </td>
                            <td class="col1" > 
                                @php
                                if (isset($row['attributes']['CLARITY'])) {
                                    echo $v['attributes'][CLARITY'];
                                }else{
                                    echo '-';
                                }
                                @endphp
                            </td>
                           
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
   
    <script src = "https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity = "sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KinkN" crossorigin="anonymous"></script>
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"> </script>
   
</body>
</html>
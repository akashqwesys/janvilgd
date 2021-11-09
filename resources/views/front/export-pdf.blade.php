<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
    <title> Laravel 8 PDF </title>    
     <style>
   table, th, td {
  border: 1px solid black;
}
.col1{
   margin: 5px;
}
.col2{
   margin: 5px;
}
   </style>
</head>
<body>
    <div class = "container mt-4">        
        <div class = "row">
            <div class = "col-md-12">
                <table class = "table"> 
                    <caption><h3>Diamond List</h3></caption>
                    <thead>
                      <tr>
                        <th scope = "col" class="col1"> Name </th>
                        <th scope = "col" class="col1"> Carat </th>                        
                        <th scope = "col" class="col1"> Price </th>
                        <th scope = "col" class="col2"> Shape </th>
                        <th scope = "col" class="col2"> Cut </th>
                        <th scope = "col" class="col2"> Color </th>
                        <th scope = "col" class="col2"> Clarity </th>
                      </tr>
                    </thead>
                    <tbody>
                        @php                        
                            foreach($diamonds as $v){
                        @endphp
                        <tr>
                            <td  class="col1"> {{$v['diamond_name']}} </td>
                            <td  class="col1"> {{$v['carat']}} </td>
                            <td class="col1" > {{round($v['price'], 2)}} </td>
                            <td class="col1" >
                                @php
                                if (isset($v['attributes']['SHAPE'])) {
                                    echo $v['attributes']['SHAPE'];
                                }
                                else{
                                    echo '-';
                                }
                                @endphp
                            </td>
                            <td class="col1" >
                                @php
                                if (isset($v['attributes']['CUT GRADE'])) {
                                    echo $v['attributes']['CUT GRADE'];
                                }
                                else{
                                    echo '-';
                                }
                                @endphp
                            </td>
                            <td class="col1" >
                                @php
                                if (isset($v['attributes']['COLOR'])) {
                                    echo $v['attributes']['COLOR'];
                                }
                                else{
                                    echo '-';
                                }
                                @endphp
                            </td>
                            <td class="col1" >
                                @php
                                if (isset($v['attributes']['CLARITY'])) {
                                    echo $v['attributes']['CLARITY'];
                                }
                                else{
                                    echo '-';
                                }
                                @endphp
                            </td>                            
                        </tr>
                        @php
                        }
                        @endphp
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</body>
</html>
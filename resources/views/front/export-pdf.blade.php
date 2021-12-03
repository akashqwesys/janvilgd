<! DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE = edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <title> Laravel 8 PDF </title>
    <style>
        table, td, th {
            border: 1px solid black;
        }
        thead {
            background: lightgray;
        }
        .col1 {
            margin: 5px;
        }
        .col2 {
            margin: 5px;
        }
        .h3 {
            font-size: 1.25rem;
            font-weight: 600;
            /* display: inline-block; */
            margin: 10px;
        }
        .title-table {
            /* display: flex;
            align-items: center;
            justify-content: center; */
            margin-bottom: 10px;
        }
        .text-center {
            text-align: center;
        }
        .mt-2 {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class=" mt-2">
        <div class="">
            <div class="">
                <table class="table" align="center">
                    <caption>
                        <div class=title-table>
                            <img src="https://janvi.akashs.in/admin_assets/images/logo-dark.png">
                            <div class="h3">
                                Diamonds List - {{ $category_name }}
                            </div>
                        </div>
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col1"> Stock No </th>
                            <th scope="col" class="col2"> Shape </th>
                            <th scope="col" class="col1"> Carat </th>
                            <th scope="col" class="col2"> Color </th>
                            <th scope="col" class="col2"> Clarity </th>
                            <th scope="col" class="col2"> Cut </th>
                            <th scope="col" class="col1"> Price </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diamonds as $v)
                        <tr>
                            <td class="col1" align="center"> {{$v['_source']['barcode']}} </td>
                            <td class="col1" align="center">
                                @if (isset($v['_source']['attributes']['SHAPE']))
                                {{ $v['_source']['attributes']['SHAPE'] }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="col1" align="center"> {{$v['_source']['expected_polish_cts']}} </td>
                            <td class="col1" align="center">
                                @if (isset($v['_source']['attributes']['COLOR']))
                                {{ $v['_source']['attributes']['COLOR'] }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="col1" align="center">
                                @if (isset($v['_source']['attributes']['CLARITY']))
                                {{ $v['_source']['attributes']['CLARITY'] }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="col1" align="center">
                                @if (isset($v['_source']['attributes']['CUT']))
                                {{ $v['_source']['attributes']['CUT'] }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="col1" align="center"> {{round($v['_source']['total'], 2)}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
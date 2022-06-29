<! DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE = edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <title> Laravel 8 PDF </title>
    <style>
        table, td, th {
            border: 1px solid lightgray;
        }
        thead {
            background: #e0e0e0;
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
                            <img src="https://janvilgd.com/admin_assets/images/logo-dark.png">
                            <div class="h3">
                                Diamonds List - {{ $category->name }}
                            </div>
                        </div>
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col1"> Stock No </th>
                            <th scope="col" class="col2"> Shape </th>
                            @if ($category->slug == '4p-diamonds')
                            <th scope="col" class="col2"> 4P Weight (CT)</th>
                            @elseif ($category->slug == 'rough-diamonds')
                            <th scope="col" class="col2"> Rough Weight (CT)</th>
                            @endif
                            <th scope="col" class="col1"> Carat </th>
                            <th scope="col" class="col2"> Color </th>
                            <th scope="col" class="col2"> Clarity </th>
                            @if ($category->slug != 'rough-diamonds')
                            <th scope="col" class="col2"> Cut </th>
                            @endif
                            <th scope="col" class="col1"> Rapaport </th>
                            <th scope="col" class="col1"> Discount </th>
                            <th scope="col" class="col1"> Price/CT </th>
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
                            @if ($category->slug == '4p-diamonds' || $category->slug == 'rough-diamonds')
                            <td scope="col" align="center"> {{ $v['_source']['makable_cts'] }} </td>
                            @endif
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
                            @if ($category->slug != 'rough-diamonds')
                            <td class="col1" align="center">
                                @if (isset($v['_source']['attributes']['CUT']))
                                {{ $v['_source']['attributes']['CUT'] }}
                                @else
                                -
                                @endif
                            </td>
                            @endif
                            <td class="col1" align="center">
                                ${{number_format($v['_source']['rapaport_price'], 2, '.', ',')}}
                            </td>
                            <td class="col1" align="center">
                                {{number_format($v['_source']['discount'] * 100, 2, '.', ',')}}%
                            </td>
                            <td class="col1" align="center">
                                ${{number_format($v['_source']['price_ct'], 2, '.', ',')}}
                            </td>
                            <td class="col1" align="right"> ${{number_format($v['_source']['total'], 2, '.', ',')}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

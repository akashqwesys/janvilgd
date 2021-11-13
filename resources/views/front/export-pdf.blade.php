<! DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE = edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <title> Laravel 8 PDF </title>
    <style>
        table {
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
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <caption>
                        <div class=title-table>
                            <img src="https://janvi.akashs.in/admin_assets/images/logo-dark.png">
                            <div class="h3">
                                Diamonds List
                            </div>
                        </div>
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col" class="col1"> Name </th>
                            <th scope="col" class="col1"> Carat </th>
                            <th scope="col" class="col1"> Price </th>
                            <th scope="col" class="col2"> Shape </th>
                            <th scope="col" class="col2"> Cut </th>
                            <th scope="col" class="col2"> Color </th>
                            <th scope="col" class="col2"> Clarity </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diamonds as $v)
                        <tr>
                            <td class="col1" align="center"> {{$v['diamond_name']}} </td>
                            <td class="col1" align="center"> {{$v['carat']}} </td>
                            <td class="col1" align="center"> {{round($v['price'], 2)}} </td>
                            <td class="col1" align="center">
                                @if (isset($v['attributes']['SHAPE']))
                                {{ $v['attributes']['SHAPE'] }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="col1" align="center">
                                @if (isset($v['attributes']['CUT GRADE']))
                                {{ $v['attributes']['CUT GRADE'] }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="col1" align="center">
                                @if (isset($v['attributes']['COLOR']))
                                {{ $v['attributes']['COLOR'] }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="col1" align="center">
                                @if (isset($v['attributes']['CLARITY']))
                                {{ $v['attributes']['CLARITY'] }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
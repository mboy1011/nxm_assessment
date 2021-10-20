@extends('layout.app')
@section('title','Rank Report')
@section('content')
    <table class="table" id="myTable">
        <thead>
            <tr>
                <th scope="col">Top</th>
                <th scope="col">Distributor Name</th>
                <th scope="col">Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <th scope="row">
                    @if($loop->index==0)
                        @if ($data[$loop->index+1]['total_sales']==$item->total_sales)
                            {{ $i }}
                        @else
                            {{ $i+=1 }}
                        @endif
                    @elseif($loop->index>0)
                        @if ($data[$loop->index-1]['total_sales']==$item->total_sales)
                            {{ $i }}
                        @else
                            {{ $i+=1 }}
                        @endif
                    @endif
                </th>
                <td>{{ $item->first_name }}</td>
                <td>@money($item->total_sales)</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('js')
    <script>
        $(function(){
            $('#myTable').DataTable();
        });
    </script>
@endsection

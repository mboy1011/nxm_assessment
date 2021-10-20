@extends('layout.app')
@section('title','Commission Report')
@section('content')
    <table class="table" id="myTable">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Invoice Number</th>
                <th scope="col">Purchaser</th>
                <th scope="col">Distributor</th>
                <th scope="col">Date</th>
                <th scope="col">Order Total</th>
                <th scope="col">Referred Count</th>
                <th scope="col">Percentage</th>
                <th scope="col">Commission</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{$item->invoice_number}}</th>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->order_date }}</td>
                    <td>{{ $item->order_total }}</td>
                    <td>{{ $item->referred_count }}</td>
                    <td>{{ $item->percentages }}</td>
                    <td>{{ $item->commission }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm view_items" data-invno="{{ $item->invoice_number }}" data-id="{{ $item->oid }}">View Items</button>
                    </td>
                </tr>
            @endforeach
 
        </tbody>
    </table>  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-left" id="exampleModalLabel">
                Invoice <span class="badge badge-light"><p id="invoice-no"></p></span>               
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <table class="table">
              <thead class="thead-dark">
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                  </tr>
              </thead>
              <tbody id="modal-tbody">

              </tbody>
          </table>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(function(){
            $('#myTable').DataTable();
            $('.view_items').click(function(){
                // Empty Modal Table
                $('#modal-tbody').empty();
                // Get id of data-id from event.listener 
                let id = $(this).data('id');
                // Get invoice no of data-invno from event.listener
                let invno = $(this).data('invno');
                $('#invoice-no').text(invno);
                const params = new URLSearchParams();
                params.append('ID', id);
                axios.post('/show',params)
                .then(function (response) {
                    // handle success
                    this.data = response.data;
                    this.data.forEach((item) => {
                        $('#modal-tbody').append(`
                            <tr>
                                <td>`+item.id+`</td>
                                <td>`+item.name+`</td>
                                <td>`+item.price+`</td>
                                <td>`+item.qantity+`</td>
                                <td>`+item.total+`</td>
                            </tr>
                        `);
                    });
                    $('#exampleModal').modal('toggle');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            });
        });
    </script>
@endsection

@extends('layout.app')
@section('title','Commission Report')
@section('css')
    <style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        /* add padding to account for vertical scrollbar */
        padding-right: 20px;
        /*  */
        position: absolute;
        z-index: 99999 !important;
        cursor: default;
        padding: 0;
        margin-top: 2px;
        list-style: none;
        background-color: #ffffff;
        border: 1px solid #ccc -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .ui-autocomplete>li {
        padding: 3px 20px;
    }

    .ui-autocomplete>li.ui-state-focus {
        background-color: #DDD;
    }

    .ui-helper-hidden-accessible {
        display: none;
    }
    </style>
@endsection
@section('content')
    <br>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon0">Distributor</span>
                </div>
                <input class="form-control autocomplete" name="dist" id="dist" placeholder="Distributor" aria-label="Distributor" aria-describedby="basic-addon0">
            </div>
        </div>
        <div class="col"></div>
        <div class="col"></div>
    </div>
    <br>
    <div class="row">
        <form action="/filter" method="post" class="form-inline">

            <div class="form-group mx-sm-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Min Date</span>
                    </div>
                    @csrf
                    @method('POST')
                    <input type="date" class="form-control" max="{{$max}}" name="min_date" id="min_date"  aria-describedby="basic-addon1" value="2001-09-11">
                </div>
            </div>
 
            <div class="form-group mx-sm-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2">Max Date</span>
                    </div>
                    <input type="date" class="form-control" name="max_date" id="max_date"  aria-describedby="basic-addon2" value="{{$max}}">
                </div>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            <div class="form-group mx-sm-5 mb-2 fw-bold">
                Total Commission: $<span id="total"></span>
            </div>
        </form>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table" id="myTable">
            <thead>
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
                        <td>{{ $item->dist_name }}</td>
                        <td>{{ $item->order_date }}</td>
                        <td>{{ $item->order_total }}</td>
                        <td>{{ $item->referred_count }}</td>
                        <td>{{ $item->percentages }}%</td>
                        <td>{{ $item->commission }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm view_items" data-invno="{{ $item->invoice_number }}" data-id="{{ $item->oid }}">View Items</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>  
    </div>
    <br>
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
    <script>
        $.when( $.ready ).then(function() {

            // DataTable Init
            oTable = $('#myTable').DataTable({
                autoFill: true
            });
            // AutoComplete JQUERY UI get DataTable Data on Column
                
            $(".autocomplete").autocomplete({
                source: oTable.columns(1).data()[0]
            });
            // 
            $('#dist').keyup(function(){
                oTable
                .columns(2)
                .search($(this).val())
                .draw() ;
            });
            // DataTable API
            oTable.$('.view_items').click(function(){
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
            // 
            internationalNumberFormat = new Intl.NumberFormat('en-US',{currency: 'USD',minimumFractionDigits: 2,})
            $('#total').text(internationalNumberFormat.format(oTable.column(7).data().sum()));
        });
    </script>
@endsection

@extends('layouts.master')
@section('title')
    {{trans_choice('general.order',2)}}
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title"> {{trans_choice('general.order',2)}}</h6>

            <div class="heading-elements">

            </div>
        </div>
        <div class="panel-body ">
            <div class="table-responsive">
                <table id="data-table" class="table table-striped table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>{{trans_choice('general.id',1)}}</th>
                        <th>{{trans_choice('general.user',1)}}</th>
                        <th>{{trans_choice('general.type',1)}}</th>
                        <th>{{trans_choice('general.status',1)}}</th>
                        <th>{{trans_choice('general.market',1)}}</th>
                        <th>{{trans_choice('general.price',1)}}</th>
                        <th>{{trans_choice('general.volume',1)}}</th>
                        <th>{{trans_choice('general.amount',1)}}</th>
                        <th>{{trans_choice('general.time',1)}}</th>
                        <th>{{ trans_choice('general.action',1) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key)
                        <?php
                        $trade_currency = \App\Models\TradeCurrency::find($key->trade_currency_id);
                        $default = \App\Models\TradeCurrency::where('default_currency', 1)->first();
                        ?>
                        <tr>
                            <td>{{ $key->id }}</td>
                            <td>
                                @if(!empty($key->user))
                                    <a href="{{url('user/'.$key->user_id.'/show')}}"> {{$key->user->first_name}}  {{$key->user->last_name}}</a>
                                @endif
                            </td>
                            <td>
                                @if($key->order_type=="ask")
                                    {{trans_choice('general.ask',1)}}
                                @endif
                                @if($key->order_type=="bid")
                                    {{trans_choice('general.bid',1)}}
                                @endif
                            </td>
                            <td>
                                @if($key->status=="pending")
                                    {{trans_choice('general.pending',1)}}
                                @endif
                                @if($key->status=="processing")
                                    {{trans_choice('general.processing',1)}}
                                @endif
                                @if($key->status=="cancelled")
                                    {{trans_choice('general.cancelled',1)}}
                                @endif
                                @if($key->status=="done")
                                    {{trans_choice('general.done',1)}}
                                    <i class="fa fa-link" data-toggle="tooltip" title="{{$key->linked_order_id}}"></i>
                                @endif
                                @if($key->status=="accepted")
                                    {{trans_choice('general.accepted',1)}}
                                @endif
                            </td>
                            <td>
                                @if(!empty($trade_currency))
                                    {{$trade_currency->xml_code}}/
                                @endif
                                @if(!empty($default))
                                    {{$default->xml_code}}
                                @endif
                            </td>
                            <td>{{ number_format($key->price,2) }}</td>
                            <td>{{round( $key->volume,6) }}</td>
                            <td>{{ number_format($key->amount,2) }}</td>
                            <td>{{ $key->created_at }}</td>
                            <td class="text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                            @if(Sentinel::hasAccess('borrowers.update'))
                                                <li><a href="{{ url('order/'.$key->id.'/cancel') }}" class="delete">
                                                        {{ trans('general.cancel') }} </a>
                                                </li>
                                                <li><a href="{{ url('order/'.$key->id.'/pending') }}" class="delete">
                                                        {{ trans('general.pending') }} </a>
                                                </li>
                                                <li><a href="{{ url('order/'.$key->id.'/done') }}" class="delete">
                                                        {{ trans('general.done') }} </a>
                                                </li>
                                            @endif
                                            @if(Sentinel::hasAccess('borrowers.delete'))
                                                <li><a href="{{ url('order/'.$key->id.'/delete') }}"
                                                       class="delete"> {{ trans('general.delete') }}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.box -->
@endsection
@section('footer-scripts')
    <script>
        $('#data-table').DataTable({
            "order": [[8, "desc"]],
            "columnDefs": [
                {"orderable": false, "targets": [9]}
            ],
            "language": {
                "lengthMenu": "{{ trans('general.lengthMenu') }}",
                "zeroRecords": "{{ trans('general.zeroRecords') }}",
                "info": "{{ trans('general.info') }}",
                "infoEmpty": "{{ trans('general.infoEmpty') }}",
                "search": "{{ trans('general.search') }}",
                "infoFiltered": "{{ trans('general.infoFiltered') }}",
                "paginate": {
                    "first": "{{ trans('general.first') }}",
                    "last": "{{ trans('general.last') }}",
                    "next": "{{ trans('general.next') }}",
                    "previous": "{{ trans('general.previous') }}"
                }
            },
            responsive: false
        });
    </script>
@endsection

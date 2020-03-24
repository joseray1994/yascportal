<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th>Zoom</th>
            <th>Email</th>
            <th>Password</th>
            <th>In use by</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="zoom-list">
    @forelse ($zoom as $zm)
        <tr id="zm_id{{$zm->id}}">
            <td>{{$zm->name }}</td>
            <td>{{$zm->email}}</td>
            <td>{{$zm->password}}</td>
            <td>{{$zm->in_use_by}}</td>
                @switch($zm->status)
                    @case(1)
                            <td class="hidden-xs">
                                <span class='badge badge-success'>Available</span>
                            </td>
                            <td>
                               <button type="button" class="btn btn-sm btn-outline-warning btn_add_user"  title="Assing User"  value="{{$zm->id}}"  ><i class="fa fa-user"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-edit"  title="Edit"  value="{{$zm->id}}"  ><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type"  title="Deactivated" data-type="confirm" value="{{$zm->id}}"><i class="fa fa-window-close"></i></button>
                            </td>
                    @break
                    @case(2)
                            <td class="hidden-xs">
                                <span class='badge badge-secondary'>Not Available</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success off-type"  title="Activated" data-type="confirm" value="{{$zm->id}}" ><i class="fa fa-check-square-o"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deletezm"  title="Delete" data-type="confirm" value="{{$zm->id}}"><i class="fa fa-trash-o"></i></button>
                            </td>
                    @break
                @endswitch 
        
        </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="8" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>
{!! $zoom->render() !!}
<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th ></th>
            <th >Client</th>
            <th>Description</th>
            <th>Interval</th>
            <th>Minutes</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="client-list">
        @forelse ($data as $client)
        <tr id="client_id{{$client->id}}">
        <td style = "background:{{$client->color}}"></td>
            <td>{{$client->name }}</td>
            <td>{{$client->description}}</td>
            <td>{{$client->interval}}</td>
            <td>{{$client->duration}}</td>
                @switch($client->status)
                    @case(1)
                            <td class="hidden-xs">
                                <span class='badge badge-success'>Activated</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-edit"  title="Edit"  value="{{$client->id}}"  ><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert off-type"  title="Deactivated" data-type="confirm" value="{{$client->id}}"><i class="fa fa-window-close"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-warning btn_add_contacts"   title="Contacts" onclick="add_contacs('{{$client->id}}')"><i class="fa fa-users"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-warning open-documents" onclick="openDocument('{{$client->id}}')"  title="Documents" value="{{$client->id}}"><i class="fa  fa-folder-open"></i></button>
                            </td>
                    @break
                    @case(2)
                            <td class="hidden-xs">
                                <span class='badge badge-secondary'>Deactivated</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success off-type"  title="Activated" data-type="confirm" value="{{$client->id}}" ><i class="fa fa-check-square-o"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert deleteClient"  title="Delete" data-type="confirm" value="{{$client->id}}"><i class="fa fa-trash-o"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-warning btn_add_contacts"  title="Contacts" onclick="add_contacs('{{$client->id}}')" ><i class="fa fa-users"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-warning open-documents" onclick="openDocument('{{$client->id}}')"  title="Documents" value="{{$client->id}}"><i class="fa  fa-folder-open"></i></button>
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
{!! $data->render() !!}
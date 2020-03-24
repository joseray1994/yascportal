<table class="table table-striped text-center" id="tag_container">
    <thead class="text-white thead-yasc">
        <tr>
            <th width="100px">ID</th>
            <th>Title</th>
            <th>User</th>
            <th>Date</th>
            <th class="hidden-xs" >Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody id="news-list">
        @forelse($data as $news)
            <tr id="news_id{{$news->id}}"  class="rowType">
                <td>{{$news->id}}</td>
                <td>{{$news->title}}</td>
                <td>{{$news->name}} {{$news->last_name}}</td>
                <td>{{$news->created_at}}</td>
                @switch($news->status)
                    @case(1)
                        <td class="hidden-xs">
                            <span class='badge badge-success'>With Comments</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info open-modal" onclick="showDetail('{{$news->id}}')" data-toggle="tooltip" title="Detail" value="{{$news->id}}"  ><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit" data-toggle="tooltip" title="Edit" value="{{$news->id}}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-op" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$news->id}}"><i class="fa fa-window-close"></i></button>
                        </td>
                    @break
                    @case(2)
                        <td class="hidden-xs">
                            <span class='badge badge-secondary'>Without Comments</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info open-modal" onclick="showDetail('{{$news->id}}')" data-toggle="tooltip" title="Detail" value="{{$news->id}}"  ><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit" data-toggle="tooltip" title="Edit" value="{{$news->id}}"  ><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert delete-op" data-toggle="tooltip" title="Delete" data-type="confirm" value="{{$news->id}}"><i class="fa fa-window-close"></i></button>
                        </td>
                    @break
                @endswitch
            </tr>
        @empty
            <tr id="table-row" class="text-center">
                <th colspan="6" class="text-center">
                    <h2><span class="badge  badge-pill badge-info">Data Not Found</span></h2>
                </th>
            </tr>
        @endforelse
    </tbody>
</table>
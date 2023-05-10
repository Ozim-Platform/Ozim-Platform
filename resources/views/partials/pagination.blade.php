@if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {!! $items->links('vendor.pagination.default') !!}
@endif
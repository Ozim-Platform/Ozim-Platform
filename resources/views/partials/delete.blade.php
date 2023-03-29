<button type="button" class="btn btn-rounded btn-danger" onclick="destroyProduct('{{ $item->_id }}', '{{ route($namespace_destroy, $item->_id) }}')" data-toggle="modal" data-target="#modal-delete">
    <span class="fa fa-trash"></span>
</button>




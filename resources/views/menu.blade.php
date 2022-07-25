<x-app-layout>
    <div class="mt-5">
        <div class="p-5 border shadow">
            <div class="row">
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-header">Create new menu</div>
                        <div class="card-body">
                            <form action="{{ route('menus.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name">Menu Text</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="menu name">
                                </div>
                                <div class="mb-3">
                                    <label for="name">Menu Url</label>
                                    <input type="text" class="form-control" name="url" id="url"
                                        placeholder="http://">
                                </div>
                                <div class="mb-3 text-center">
                                    <input type="submit" class="btn btn-primary btn-sm">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="shadow p-3">
                        <ul class="sortableitem">
                            @foreach ($menulist as $item)
                                <li>
                                    <span class="p-1 border d-block my-1 bg-light d-flex justify-content-between">
                                        <span class="text">
                                            <i class="icon-move"></i>
                                            {{ $item->name }}</span>
                                        <a data-bs-toggle="collapse" href="#collapseExample{{ $item->id }}"
                                            role="button" aria-expanded="false" aria-controls="collapseExample"><i
                                                class="fa fa-caret-down"></i></a>

                                    </span>
                                    <div class="collapse pl-3" id="collapseExample{{ $item->id }}">
                                        <form class="p-3" action="{{ route('menus.update', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text">Menu Text</span>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $item->name }}">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text">Menu Url</span>
                                                <input type="text" class="form-control form-control-sm"
                                                    value="{{ $item->url }}">
                                            </div>
                                            <div class="text-end"><input type="submit" class="btn btn-outline-primary btn-sm" value="save"></div>

                                        </form>
                                    </div>
                                    <ul></ul>
                                </li>
                            @endforeach
                        </ul>
                        <div class="my-3 text-center">
                            <button id="update_menu" class="btn btn-primary btn-sm">Update Menu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="serialize_output2"></div>
    </div>


    @push('script')
        <script>
            var group = $(".sortableitem").sortable({
                group: 'serialization',
                delay: 500,
                onDrop: function($item, container, _super) {
                    var data = group.sortable("serialize").get();

                    var jsonString = JSON.stringify(data, null, ' ');

                    $('#serialize_output2').text(jsonString);
                    _super($item, container);
                }
            });

            $(document).on('click','#update_menu',function(event){
                let url = "{{ route('menus.updateAll') }}"
            })
        </script>
    @endpush
</x-app-layout>

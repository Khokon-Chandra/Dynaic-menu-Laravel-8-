<x-app-layout>


    @php
        ob_start();
    @endphp
    <li data-id="[[id]]">
        <span class="p-1 border d-block my-1 bg-light d-flex justify-content-between">
            <span class="text">
                <i class="fa-solid fa-arrows-up-down-left-right"></i>
                <span class="ml-2">[[name]]</span></span>
            <a data-bs-toggle="collapse" href="#collapseExample[[id]]" role="button" aria-expanded="false"
                aria-controls="collapseExample"><i class="fa fa-caret-down"></i></a>

        </span>
        <div class="collapse pl-3" id="collapseExample[[id]]">
            <form class="p-3" action="[[route]]" method="POST">
                @csrf
                @method('PUT')
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Menu Text</span>
                    <input type="text" class="form-control form-control-sm" value="[[name]]">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Menu Url</span>
                    <input type="text" class="form-control form-control-sm" value="[[url]]">
                </div>
                <div class="text-end"><input type="submit" class="btn btn-outline-primary btn-sm" value="save"></div>

            </form>
        </div>
        <ul>[[children]]</ul>
    </li>

    @php
        $MenuObject->setContent(ob_get_clean());
    @endphp





    <div class="mt-5 p-3">
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
                            {!! $MenuObject->htmlParser($item) !!}
                        @endforeach
                    </ul>
                    <div class="my-3 text-center">
                        <button id="update_menu" class="btn btn-primary btn-sm">Update Menu</button>
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
                handle: 'i.fa-arrows-up-down-left-right',
                onDrop: function($item, container, _super) {
                    var data = group.sortable("serialize").get();

                    var jsonString = JSON.stringify(data, null, ' ');

                    $('#serialize_output2').text(jsonString);
                    _super($item, container);
                }
            });

            $(document).on('click', '#update_menu', function(event) {

                if ($('#serialize_output2').text() != "") {
                    let url = "{{ route('menus.updateAll') }}"
                    let jsonData = JSON.parse($('#serialize_output2').text());
                    axios.post(url, {
                            data: jsonData[0]
                        })
                        .then((response) => {
                            console.log(response.data);
                        }).catch((error) => {
                            console.log(error);
                        })
                }

            })
        </script>
    @endpush
</x-app-layout>

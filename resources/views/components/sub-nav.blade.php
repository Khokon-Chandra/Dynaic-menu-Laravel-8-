@props(['items'])
@foreach ($items as $item)
    <li data-id="{{ $item->id }}">
        <span class="p-1 px-2 border d-block my-1 bg-light d-flex justify-content-between">
            <span class="text">
                <i class="fa-solid fa-arrows-up-down-left-right"></i>
                <span class="ml-2 menu_text">{{ $item->name }}</span></span>
            <a data-bs-toggle="collapse" href="#collapseExample{{ $item->id }}" role="button" aria-expanded="false"
                aria-controls="collapseExample"><i class="fa fa-caret-down"></i></a>

        </span>
        <div class="collapse pl-3" id="collapseExample{{ $item->id }}">
            <form class="p-3j updateMenuItem" action="{{ route('menus.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Menu Text</span>
                    <input type="text" name="name" class="form-control form-control-sm menu_name" value="{{ $item->name }}">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text">Menu Url</span>
                    <input type="text" name="url" class="form-control form-control-sm" value="{{ $item->url }}">
                </div>
                <div class="text-end"><input type="submit" class="btn btn-outline-primary btn-sm" value="save"></div>

            </form>
        </div>
        <ul>
            @if ($item->children->count())
                <x-sub-nav :items="$item->children" />
            @endif
        </ul>
    </li>
@endforeach

<div>
    <div class="row mb-4">
        <div class="col form-inline">
            Per Page: &nbsp;
            <select wire:model="perPage" class="form-control">
                <option>10</option>
                <option>15</option>
                <option>25</option>
            </select>
        </div>

        <div class="col">
            <input wire:model="search" class="form-control" type="text" placeholder="Search Contacts...">
        </div>
    </div>

    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th><a @include('includes._sort-button', ['field' => 'title']) role="button" href="#">
                        Title
                        @include('includes._sort-icon', ['field' => 'title'])
                    </a></th>
{{--                <th><a wire:click.prevent="sortBy('email')" role="button" href="#">--}}
{{--                        Description--}}
{{--                        @include('includes._sort-icon', ['field' => 'description'])--}}
{{--                    </a>--}}
{{--                </th>--}}
                <th><a wire:click.prevent="sortBy('status')" role="button" href="#">
                        Status
                        @include('includes._sort-icon', ['field' => 'status'])
                    </a>
                </th>
                <th><a wire:click.prevent="sortBy('activity')" role="button" href="#">
                        Activity
                        @include('includes._sort-icon', ['field' => 'activity'])
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($features as $feature)
                <tr>
                    <td>{{ $feature->title }}</td>

{{--                    <td>{{ Str::words($feature->description,10) }}</td>--}}
                    <td>{{ $feature->status??"-" }}</td>
                    <td>
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i> {{ $feature->votes_count}} /
                        <i class="far fa-comments"></i> {{$feature->comments_count}}
                        ({{ $feature->votes_count + ($feature->comments_count * 2)}})
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col">
            {{ $features->links() }}
        </div>

        <div class="col text-right text-muted">
            Showing {{ $features->firstItem() }} to {{ $features->lastItem() }} out of {{ $features->total() }} results
        </div>
    </div>
</div>

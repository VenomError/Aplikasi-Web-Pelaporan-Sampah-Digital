@props([
    'search' => null,
    'col' => 10,
    'paginate' => null,
])

<div class="table-list-card">
    <div class="table-top">
        <div class="d-flex justify-content-between">
            <div class="search-set">
                <div class="search-input">
                    <div class="dataTables_filter" id="DataTables_Table_0_filter">
                        <label>
                            <input
                                class="form-control form-control-sm"
                                type="search"
                                aria-controls="DataTables_Table_0"
                                placeholder="Search"
                                wire:model.lazy='search'
                            >
                        </label>
                    </div>
                </div>
            </div>

        </div>
        {{ $header ?? '' }}
    </div>
    <div class="table-responsive">
        <table class="table-bordered product-list table-hover table-striped-rows table">
            <thead>
                {{ $head }}
            </thead>
            <tbody>
                {{ $body }}
            </tbody>
        </table>
    </div>
    @if (method_exists($paginate, 'links'))
        <div class="mt-3 mb-3" >
            {{ $paginate->links() }}
        </div>
    @endif

</div>

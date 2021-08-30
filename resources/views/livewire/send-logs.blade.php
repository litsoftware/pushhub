<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="">
        <div class="">
            <!-- Top Bar -->
            <div class="flex justify-between">
                <div class="w-2/4 flex space-x-4"></div>

                <div class="space-x-2 flex items-center">
                    <x-input.group borderless paddingless for="perPage" label="Per Page">
                        <x-input.select wire:model="perPage" id="perPage">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </x-input.select>
                    </x-input.group>
                </div>
            </div>

            <!-- Table -->
            <div class="flex-col space-y-4 mt-4">
                <x-table>
                    <x-slot name="head">
                        <x-table.heading sortable multi-column>Title</x-table.heading>
                        <x-table.heading sortable multi-column>Name</x-table.heading>
                        <x-table.heading sortable multi-column>Configuration</x-table.heading>
                        <x-table.heading sortable multi-column>Version</x-table.heading>
                        <x-table.heading sortable multi-column>Created At</x-table.heading>
                        <x-table.heading />
                    </x-slot>

                    <x-slot name="body">
                        @forelse ($rows as $row)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $row->id }}">
                                <x-table.cell>
                                    <span href="#" class="inline-flex space-x-2 truncate text-sm leading-5">
                                        <p class="text-cool-gray-600 truncate">
                                            {{ $row->title }}
                                        </p>
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="text-cool-gray-900 font-medium">{{ $row->name }} </span>
                                </x-table.cell>

                                <x-table.cell>
                                    {{ $row->conf }}
                                </x-table.cell>

                                <x-table.cell>
                                    {{ $row->version }}
                                </x-table.cell>

                                <x-table.cell>
                                    {{ $row->created_at }}
                                </x-table.cell>

                                <x-table.cell>
                                    <x-button.link wire:click="edit({{ $row->id }})">Edit</x-button.link>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="7">
                                    <div class="flex justify-center items-center space-x-2">
                                        <x-icon.inbox class="h-8 w-8 text-cool-gray-400" />
                                        <span class="font-medium py-8 text-cool-gray-400 text-xl">No data found...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-slot>
                </x-table>

                <div>
                    {{ $rows->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

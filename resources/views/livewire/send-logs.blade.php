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
                        <x-table.heading sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null" >ID</x-table.heading>
                        <x-table.heading sortable multi-column wire:click="sortBy('updated_at')" :direction="$sorts['updated_at'] ?? null">Time</x-table.heading>
                        <x-table.heading sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status</x-table.heading>
                        <x-table.heading sortable multi-column wire:click="sortBy('content')" :direction="$sorts['content'] ?? null">Content</x-table.heading>
                    </x-slot>

                    <x-slot name="body">
                        @forelse ($rows as $row)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $row->id }}">
                                <x-table.cell>
                                    {{ $row->id }}
                                </x-table.cell>

                                <x-table.cell>
                                    <span href="#" class="inline-flex space-x-2 truncate text-sm leading-5">
                                        <p class="text-cool-gray-600 truncate">
                                            {{ $row->updated_at }}
                                        </p>
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <div>{{ $row->status }}</div>
                                    <div>{{ $row->reason }}</div>
                                </x-table.cell>

                                <x-table.cell>
                                    {{ $row->content }}
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="3">
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

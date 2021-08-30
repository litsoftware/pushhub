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

                    <x-dropdown label="Bulk Actions">
                        <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                            <x-icon.download class="text-cool-gray-400"/> <span>Export</span>
                        </x-dropdown.item>

                        <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                            <x-icon.trash class="text-cool-gray-400"/> <span>Delete</span>
                        </x-dropdown.item>
                    </x-dropdown>

                    <x-button.primary wire:click="create"><x-icon.plus/> New</x-button.primary>
                </div>
            </div>

            <!-- Table -->
            <div class="flex-col space-y-4 mt-4">
                <x-table>
                    <x-slot name="head">
                        <x-table.heading class="pr-0 w-8">
                            <x-input.checkbox wire:model="selectPage" />
                        </x-table.heading>
                        <x-table.heading sortable multi-column>Title</x-table.heading>
                        <x-table.heading sortable multi-column>DSN</x-table.heading>
                        <x-table.heading sortable multi-column>Configuration</x-table.heading>
                        <x-table.heading sortable multi-column>Version</x-table.heading>
                        <x-table.heading sortable multi-column>Created At</x-table.heading>
                        <x-table.heading />
                    </x-slot>

                    <x-slot name="body">
                        @if ($selectPage)
                            <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                                <x-table.cell colspan="6">
                                    @unless ($selectAll)
                                        <div>
                                            <span>You have selected <strong>{{ $rows->count() }}</strong> channels, do you want to select all <strong>{{ $rows->total() }}</strong>?</span>
                                            <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                        </div>
                                    @else
                                        <span>You are currently selecting all <strong>{{ $rows->total() }}</strong> channels.</span>
                                    @endif
                                </x-table.cell>
                            </x-table.row>
                        @endif

                        @forelse ($rows as $row)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $row->id }}">
                                <x-table.cell class="pr-0">
                                    <x-input.checkbox wire:model="selected" value="{{ $row->id }}" />
                                </x-table.cell>

                                <x-table.cell>
                                    <span href="#" class="inline-flex space-x-2 truncate text-sm leading-5">
                                        <p class="text-cool-gray-600 truncate">
                                            {{ $row->title }}
                                        </p>
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="text-cool-gray-900 font-medium">{{ sprintf("%s://%s", $row->type, $row->name) }} </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <div class="bg-gray-100 px-4 py-4 rounded-md" style="width: 500px; overflow: scroll">
                                        {{ $row->conf }}
                                    </div>
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

        <!-- Delete Modal -->
        <form wire:submit.prevent="deleteSelected">
            <x-modal.confirmation wire:model.defer="showDeleteModal">
                <x-slot name="title">Delete Channel</x-slot>

                <x-slot name="content">
                    <div class="py-8 text-cool-gray-700">Are you sure you? This action is irreversible.</div>
                </x-slot>

                <x-slot name="footer">
                    <x-button.secondary wire:click="$set('showDeleteModal', false)">Cancel</x-button.secondary>

                    <x-button.primary type="submit">Delete</x-button.primary>
                </x-slot>
            </x-modal.confirmation>
        </form>

        <!-- Save Modal -->
        <form wire:submit.prevent="save">
            <x-modal.dialog wire:model.defer="showEditModal">
                <x-slot name="title">Edit Channel</x-slot>

                <x-slot name="content">
                    <x-input.group for="title" label="Title" :error="$errors->first('editing.title')">
                        <x-input.text wire:model="editing.title" id="title" placeholder="Title" />
                    </x-input.group>

                    <x-input.group for="name" label="Name" :error="$errors->first('editing.name')">
                        <x-input.text wire:model="editing.name" id="name" placeholder="Name" />
                    </x-input.group>

                    <x-input.group for="type" label="Type" :error="$errors->first('editing.type')">
                        <x-input.select wire:model="editing.type" id="name" placeholder="Type">
                            <option>请选择</option>
                            <option value="{{ \App\Notifier\Channel\ChannelTypes::TypeChat }}">即时通信</option>
                            <option value="{{ \App\Notifier\Channel\ChannelTypes::TypeEmail }}">邮件</option>
                            <option value="{{ \App\Notifier\Channel\ChannelTypes::TypeSms }}">短信</option>
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="conf" label="Config" :error="$errors->first('editing.name')">
                        <x-input.textarea wire:model="editing.conf" id="name" placeholder="conf" />
                    </x-input.group>
                </x-slot>

                <x-slot name="footer">
                    <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>

                    <x-button.primary type="submit">Save</x-button.primary>
                </x-slot>
            </x-modal.dialog>
        </form>
    </div>
</div>

<div>
    <div class="flex">
        <div class="flex-none">
            <div class="text-xl mb-2">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input wire:model="filterCampaigns" id="filter-campaigns" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3">
                        <label for="filter-campaigns" class="font-medium text-gray-700">Campaigns</label>
                    </div>
                </div>
            </div>
            @if($filterCampaigns)
                <div wire:click="selectAllCampaigns" class="text-gray-600 hover:underline cursor-pointer">Select all</div>
                @foreach($allCampaigns as $campaign)
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input wire:model="campaigns.{{ $campaign->id }}" id="campaign-{{ $campaign->id }}" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="campaign-{{ $campaign->id }}" class="font-medium text-gray-700">{{ $campaign->name ?? $campaign->key }}</label>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="flex-none ml-6">
            <div class="text-xl mb-2">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input wire:model="filterABTests" id="filter-ab-tests" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3">
                        <label for="filter-ab-tests" class="font-medium text-gray-700">AB Tests</label>
                    </div>
                </div>
            </div>
            @if($filterABTests)
                <div wire:click="selectAllABTests" class="text-gray-600 hover:underline cursor-pointer">Select all</div>

                @foreach($allABTests as $abTest)
                    <div class="relative flex items-start mt-3">
                        <div class="flex items-center h-5">
                            <input wire:model="abTests.{{ $abTest->id }}" id="ab-test-{{ $abTest->id }}"  type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="ab-test-{{ $abTest->id }}" class="font-medium text-gray-700">{{ $abTest->key }}</label>
                        </div>

                    </div>
                    @if($abTests[$abTest->id])
                        <div class="ml-6">
                            @foreach($abTest->options as $option)
                                <div class="relative flex items-start mt-1">
                                    <div class="flex items-center h-5">
                                        <input wire:model="abTestOptions.{{ $abTest->id }}.{{ $option->id }}" id="ab-test-option-{{ $abTest->id }}-{{ $option->id }}"  type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="ab-test-option-{{ $abTest->id }}-{{ $option->id }}" class="font-medium text-gray-700">{{ $option->key }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        <div class="flex-none ml-12">
            <div class="text-xl">Visitors: {{ $stats['visitors'] }}</div>

            @if($stats['visitors'] > 0)
                <div class="text-xl mt-2">Goals:</div>

                <div class="flex flex-col mt-2">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Goal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Absolute
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($stats['goals'] as $goal)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $goal['goal']->key }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $goal['total']}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format(100 * $goal['total'] / $stats['visitors'], 1) }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
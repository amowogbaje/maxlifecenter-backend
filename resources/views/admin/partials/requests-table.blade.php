<div class="overflow-x-auto">
    <table class="w-full min-w-[1024px]">
        <thead>
            <tr class="table-header rounded-t-lg h-16">
                <th class="table-cell text-left font-bold text-dashboard-primary w-16">SN</th>
                <th class="table-cell text-left font-bold text-dashboard-primary w-48">Name</th>
                <th class="table-cell text-left font-bold text-dashboard-primary w-40">Post ID</th>
                <th class="table-cell text-center font-bold text-dashboard-primary w-32">Bonus Point</th>
                <th class="table-cell text-center font-bold text-dashboard-primary w-56">Date Created</th>
                <th class="table-cell text-center font-bold text-dashboard-primary w-32">Status</th>
                <th class="table-cell text-left font-bold text-dashboard-primary">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tableData as $row)
                <tr class="table-row border-t h-16">
                    <td class="table-cell">{{ $row['sn'] }}</td>
                    <td class="table-cell">{{ $row['name'] }}</td>
                    <td class="table-cell">{{ $row['postId'] }}</td>
                    <td class="table-cell text-center">{{ $row['bonusPoint'] }}</td>
                    <td class="table-cell text-center">{{ $row['dateCreated'] }}</td>
                    <td class="table-cell text-center">
                        <span class="p-3 px-4 rounded-full text-xs font-semibold text-white
                            @switch($row['status'])
                                @case('pending') bg-yellow-400 @break
                                @case('approved') bg-green-400 @break
                                @case('declined') bg-red-400 @break
                            @endswitch
                        ">
                            {{ ucfirst($row['status']) }}
                        </span>
                    </td>
                    <td class="table-cell">
                        <div class="flex flex-wrap text-sm">
                            <button class="text-red-500">Change Status</button>
                            <button class="text-green-500">View Details</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="table-row">
                    <td colspan="7" class="table-cell text-center text-gray-500">No user upload requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="border-t border-table-border p-4 flex flex-col lg:flex-row items-center justify-between gap-4">
    {{-- You can integrate Laravel's paginator here if you use it in the controller --}}
    <div class="pagination-controls-placeholder">Showing 1 to 6 of 100 entries</div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity History Report - Daily Activity Support Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Nav -->
        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded shadow-md">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Custom Activity History Report</h1>
                <p class="text-xs text-gray-500">Query support task histories over specific date ranges</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded">
                    Back to Tracker
                </a>
                <a href="{{ route('tasks.handing-over') }}" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-3 rounded">
                    Handing-Over View
                </a>
            </div>
        </div>

        <!-- Date Filter Form -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-6 mb-8">
            <form action="{{ route('tasks.report') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-gray-700 text-xs font-bold mb-1" for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 text-sm focus:outline-none focus:shadow-outline" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-xs font-bold mb-1" for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 text-sm focus:outline-none focus:shadow-outline" required>
                </div>

                <div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded text-sm focus:outline-none focus:shadow-outline">
                        Filter Report
                    </button>
                    @if($startDate || $endDate)
                        <a href="{{ route('tasks.report') }}" class="ml-2 text-xs text-gray-500 hover:underline">Clear Filter</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Report Table -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">
                @if($startDate && $endDate)
                    Showing Activities From <span class="text-indigo-600">{{ $startDate }}</span> To <span class="text-indigo-600">{{ $endDate }}</span>
                @else
                    All Historical Activity Records
                @endif
            </h2>

            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title & Description</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Priority</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Remarks</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Updated By / Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 font-medium whitespace-no-wrap">{{ $task->title }}</p>
                                <p class="text-gray-500 text-xs">{{ $task->description }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $task->priority == 'Urgent' ? 'bg-red-100 text-red-800' : ($task->priority == 'High' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $task->priority }}
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $task->status == 'Done' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-600">
                                {{ $task->remarks ?? 'No remarks' }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-600">
                                <span class="font-semibold text-gray-800">{{ $task->user->name ?? 'Unassigned' }}</span><br>
                                <span class="text-xs text-gray-400">{{ $task->updated_at->format('M d, Y - H:i') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                No activity records found for the selected duration.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
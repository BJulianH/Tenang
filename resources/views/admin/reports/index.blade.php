@extends('layouts.admin')

@section('title', 'Reports Management - Tenang Admin')
@section('page_title', 'Reports Management')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Reports</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-flag text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Resolved</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Critical</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['critical'] }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-lg card-shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">All Reports</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Report Details
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Severity
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-{{ $report->severity_color }}-100 flex items-center justify-center">
                                        <i class="fas fa-flag text-{{ $report->severity_color }}-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $report->reporter->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 line-clamp-1">
                                        {{ Str::limit($report->reason, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $report->reportable_type_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $report->severity_color }}-100 text-{{ $report->severity_color }}-800">
                                {{ ucfirst($report->severity) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $report->status_color }}-100 text-{{ $report->status_color }}-800">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.reports.show', $report) }}" class="text-primary-600 hover:text-primary-900 mr-3">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('admin.reports.resolve', $report) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="resolve">
                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-check"></i> Resolve
                                </button>
                            </form>
                            <form action="{{ route('admin.reports.resolve', $report) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="dismiss">
                                <button type="submit" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-times"></i> Dismiss
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
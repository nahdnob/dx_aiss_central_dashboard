@props(['riskAssessments', 'lines' => []])

<div class="mb-6">
    {{-- Title & Description --}}
    <div class="flex items-end justify-between">
        <x-layout.section-title eyebrow="Data" title="Risk Assessment Documents" />
    </div>
    {{-- ===== TABLE RISK ASSESSMENT DATA ===== --}}
    <x-table :headers="['Name', 'RA No', 'RA Level', 'Security Rank', 'Rev', 'RA File', 'Actions']">
        {{-- Table Header --}}
        <x-slot:toolbar>
            <x-table.search :action="route('risk-assessments.index')" placeholder="Search title, document number..." />
        </x-slot:toolbar>
        {{-- Table Content --}}
        @forelse ($riskAssessments as $item)
            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                {{-- Name --}}
                <td class="px-5 py-4">
                    <div class="font-semibold text-gray-900 text-sm">{{ $item->name }}</div>
                </td>
                {{-- RA No --}}
                <td class="px-5 py-4 text-center">
                    <div class="text-sm text-gray-600 font-mono">{{ $item->ra_no }}</div>
                </td>
                {{-- RA Level --}}
                <td class="px-5 py-4 text-center">
                    <div class="text-sm text-gray-600 font-mono">{{ $item->ra_level ?? '-' }}</div>
                </td>
                {{-- Security Rank --}}
                <td class="px-5 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200 font-mono">
                        {{ $item->ra_security_rank ?? '-' }}
                    </span>
                </td>
                {{-- Revision --}}
                <td class="px-5 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-bold bg-slate-400 text-white">
                        {{ $item->revision }}
                    </span>
                </td>
                {{-- RA File --}}
                <td class="px-5 py-4 text-center">
                    <x-table.file-link :path="$item->link" />
                </td>
                {{-- Actions --}}
                <td class="px-5 py-4">
                    <x-ui.action-hover>
                        {{-- Button Edit --}}
                        <x-ui.button-group variant="info" class="!rounded-full">
                            <button data-modal-open="edit-ra-modal-{{ $item->id }}" type="button" title="Edit" class="!w-8">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </x-ui.button-group>
                        {{-- Button Delete --}}
                        <form action="{{ route('risk-assessments.destroy', $item->id) }}" method="POST" aria-label="Delete risk assessment" onsubmit="return confirm('Delete this document?')">
                            @csrf
                            @method('DELETE')
                            <x-ui.button-group variant="danger" class="!rounded-full">
                                <button type="submit" title="Delete" class="!w-8">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </x-ui.button-group>
                        </form>
                    </x-ui.action-hover>
                </td>
            </tr>
            {{-- Modal Edit --}}
            <x-modal.pages.edit-risk-assessment :item="$item" :lines="$lines" />
        @empty
            {{-- Table Empty --}}
            <x-table.empty :colspan="7" message="No Risk Assessment documents yet." />
        @endforelse
        {{-- Table Footer --}}
        <x-slot:footer>
            <x-pagination :paginator="$riskAssessments" label="document" variant="numbered" />
        </x-slot:footer>
    </x-table>
</div>

<footer class="mt-auto py-6 relative overflow-hidden">
    {{-- Decorative subtle top border --}}
    <div class="absolute top-0 left-10 right-10 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
    
    <div class="px-4 mx-auto w-full">
        <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
            {{-- Left side: System name --}}
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <span class="font-bold tracking-wider text-red-600 italic">DENSO</span>
                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                <span class="font-medium text-slate-500">AISS Central Dashboard</span>
            </div>
            {{-- Right side: Copyright / Year --}}
            <div class="text-xs font-medium text-sky-600">
                &copy; {{ date('Y') }} PriaMisterius
            </div>
        </div>
    </div>
</footer>
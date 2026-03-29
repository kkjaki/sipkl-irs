@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Manajemen Program PKL') }}
                </h2>
            </div>
        </header>

        <!-- Container & Header Data -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 flex justify-between items-center relative rounded-t-xl text-white">
                <div class="flex items-center gap-2.5 text-white">
                    <x-heroicon-o-briefcase class="w-6 h-6"/>
                    <h2 class="font-bold text-lg m-0">Data Program PKL</h2>
                </div>
                <a href="{{ route('internship-programs.create') }}" class="bg-white text-teal-600 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-semibold flex items-center gap-2 transition-colors shadow-sm">
                    <x-heroicon-o-plus class="w-4 h-4"/> Buat Program
                </a>
            </div>

            <!-- Grid Cards Container -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($internshipPrograms as $program)
                    <!-- Desain Card Program -->
                    <div x-data="{ open: false }" class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all flex flex-col">
                        
                        <!-- Header Card -->
                        <div class="text-lg font-bold text-gray-800 p-4 border-b">
                            {{ $program->name }}
                        </div>

                        <!-- Body Card - Mentor Data -->
                        <div class="mx-4 mt-5 flex items-center gap-3">
                            <x-heroicon-o-user-circle class="w-9 h-9 text-gray-400" />
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-500">Mentor:</span>
                                <span class="text-sm font-bold text-teal-600">{{ $program->mentor->user->name ?? 'Belum ada Mentor' }}</span>
                            </div>
                        </div>

                        <!-- Body Card - Kode Undangan (Fitur Copy) -->
                        <div class="text-sm font-medium text-gray-500 mx-4 mt-5">Kode Undangan</div>
                        
                        <div x-data="{ copied: false }" class="bg-gray-50 rounded-md p-3 mx-4 mt-1.5 flex justify-between items-center border border-gray-200">
                            <span class="font-mono text-xl font-black text-brand-primary tracking-widest">{{ $program->invitation_code }}</span>
                            
                            <button @click="navigator.clipboard.writeText('{{ $program->invitation_code }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                    class="p-2 rounded-md hover:bg-gray-200 transition-colors text-gray-500">
                                <template x-if="!copied">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                    </svg>
                                </template>
                                <template x-if="copied">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </template>
                            </button>
                        </div>

                        <!-- Body Card - PERIODE PROGRAM (HIGHLIGHTED) -->
                        <h4 class="text-sm font-medium text-gray-500 mx-4 mt-5">Periode Program</h4>
                        <div class="mx-4 mt-1.5 mb-5 p-3 bg-slate-50 rounded-lg border border-slate-100 flex flex-col gap-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex items-center gap-1.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Mulai
                                </span>
                                <span class="px-3 py-1 text-sm font-medium bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">{{ $program->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex items-center gap-1.5 text-sm text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Selesai
                                </span>
                                <span class="px-3 py-1 text-sm font-medium bg-rose-50 text-rose-700 rounded-full border border-rose-100">{{ $program->end_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons (Footer) -->
                        <div class="mt-auto flex border-t divide-x divide-gray-100 bg-gray-50 rounded-b-lg">
                            <a href="{{ route('internship-programs.edit', $program->id) }}" class="w-1/2 flex justify-center items-center gap-2 py-3 text-blue-600 hover:bg-blue-100 transition-colors font-medium rounded-bl-lg">
                                Edit <x-heroicon-o-pencil-square class="w-5 h-5"/>
                            </a>
                            
                            <button @click="open = true" class="w-1/2 flex justify-center items-center gap-2 py-3 text-red-600 hover:bg-red-100 transition-colors font-medium rounded-br-lg">
                                Hapus <x-lucide-trash class="w-5 h-5"/>
                            </button>
                        </div>

                        <!-- Modal Hapus -->
                        <template x-if="open">
                            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                <div @click.away="open = false" class="w-fit px-32 py-7 bg-white rounded-md flex flex-col justify-center items-center gap-8 shadow-xl">
                                    <section class="flex flex-col">
                                        <span class="text-center text-neutral-800 text-xl">
                                            Apakah Anda yakin ingin menghapus
                                        </span>
                                        <span class="text-center text-neutral-800 text-xl font-bold">
                                            Program PKL ini?
                                        </span>
                                    </section>
                                    <div class="inline-flex justify-between items-center gap-36 w-full px-4">
                                        <button @click="open = false" class="px-5 py-2 rounded-md outline outline-1 outline-stone-300 hover:bg-gray-400 hover:text-white hover:outline-none text-lg transition-colors">
                                            Tidak
                                        </button>

                                        <form action="{{ route('internship-programs.destroy', $program->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-7 py-2 rounded-md text-white bg-brand-primary hover:bg-teal-500 hover:text-white transition-colors text-lg">
                                                Ya
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                @empty
                    <div class="col-span-full w-full text-center py-10 rounded-xl bg-gray-50 border border-gray-100 mt-4"><p class="text-gray-500">Tidak ada data ditemukan.</p></div>
                @endforelse
            </div>
        </div>
    </main>
@endsection

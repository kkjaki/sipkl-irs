@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </header>

        <div class="w-full mx-auto">
            <div class="overflow-hidden">
                <div class="text-gray-900 dark:text-gray-100">

                    {{-- Profil Siswa --}}
                    <div class="w-full bg-white rounded-xl shadow-sm border border-gray-100 px-0 py-0 mb-6">
                        <div class="bg-[#48CFCB] text-white px-6 py-4 font-semibold text-lg rounded-t-xl">
                            Profil Industri
                        </div>
                        <div class="p-6">
                            <div class="space-y-2">
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Nama industri</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">PT. Internet Rakyat Sejahtera</span>
                                </div>
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Alamat</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">RT 4/RW 2, Kec. Susukan, Kab. Banjarnegara, Jawa Tengah,
                                        Indonesia</span>
                                </div>
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Kontak</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">08 Berapa Manis</span>
                                </div>
                                <div class="flex border-b py-2">
                                    <span class="w-40 font-medium text-gray-700">Nama Pimpinan</span>
                                    <span class="mx-2">:</span>
                                    <span class="flex-1 text-gray-900">Si Ganteng</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dashboard Content --}}
                    <div class="py-0">
                        <div class="w-full">

                            {{-- Cards --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                                {{-- Card Jumlah Siswa --}}
                                <div
                                    class="w-full h-48 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-center items-center gap-2.5">
                                    <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                                        <div class="text-neutral-800 text-2xl font-extrabold leading-7">Jumlah Siswa</div>
                                        <div class="text-neutral-800 text-2xl font-normal leading-7">120</div>
                                    </div>
                                    <div class="px-5 py-0.5 inline-flex flex-col justify-center items-center gap-2.5 overflow-hidden">
                                        {{-- Icon --}}
                                        <x-heroicon-s-user-group
                                            class="w-14 h-14 text-stone-900 transition-colors duration-100 group-hover:text-brand-primary" />
                                    </div>
                                </div>

                                {{-- Card Jumlah Sekolah --}}
                                <div
                                    class="w-full h-48 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-start items-center gap-2.5 flex-wrap content-center">
                                    <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                                        <div class="text-neutral-800 text-2xl font-bold leading-7">Jumlah Sekolah</div>
                                        <div class="text-neutral-800 text-2xl font-normal leading-7">3</div>
                                    </div>
                                    <div class="px-5 inline-flex flex-col justify-center items-center gap-2.5 overflow-hidden">
                                        {{-- Icon --}}
                                        <i class="fas fa-school text-5xl text-stone-900"></i>
                                    </div>
                                </div>

                                {{-- Card Pendamping Industri --}}
                                <div
                                    class="w-full h-48 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-start items-center gap-2.5">
                                    <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                                        <div class="text-neutral-800 text-2xl font-bold leading-7">Pendamping Industri
                                        </div>
                                        <div class="text-neutral-800 text-2xl font-normal leading-7">32</div>
                                    </div>
                                    <div class="px-5 flex justify-center items-center gap-2.5">
                                        {{-- Icon --}}
                                        <i class="w-12 h-12 fas fa-user-tie text-5xl text-stone-900"></i>
                                    </div>
                                </div>

                                {{-- Card Guru Pembimbing --}}
                                <div
                                    class="w-full h-48 px-7 py-5 bg-white rounded-xl shadow-md outline outline-1 outline-offset-[-1px] outline-gray-300 inline-flex justify-start items-center gap-2.5">
                                    <div class="flex-1 inline-flex flex-col justify-start items-start gap-2.5">
                                        <div class="text-neutral-800 text-2xl font-bold leading-7">Guru Pembimbing</div>
                                        <div class="text-neutral-800 text-2xl font-normal leading-7">5</div>
                                    </div>
                                    <div class="px-5 flex justify-center items-center gap-2.5">
                                        {{-- Icon --}}
                                        <i class="w-12 h-12 fas fa-user-graduate text-5xl text-stone-900"></i>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
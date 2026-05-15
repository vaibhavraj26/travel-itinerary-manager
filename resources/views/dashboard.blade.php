@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.22),_transparent_34%),radial-gradient(circle_at_top_right,_rgba(244,114,182,0.18),_transparent_28%),linear-gradient(180deg,_rgba(2,6,23,0.98),_rgba(15,23,42,1))]"></div>
        <div class="relative mx-auto max-w-7xl px-6 py-10 lg:px-8 lg:py-14">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="mb-4 inline-flex items-center rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-cyan-200">
                        Dashboard
                    </p>
                    <h1 class="text-4xl font-semibold tracking-tight text-white sm:text-5xl">
                        Plan every trip from one calm control center.
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                        Track destinations, confirm bookings, and keep your itinerary moving without jumping between tabs.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:flex sm:flex-wrap sm:justify-end">
                    <a href="#" class="inline-flex items-center justify-center rounded-full bg-cyan-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                        New trip
                    </a>
                    <a href="#" class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        View calendar
                    </a>
                </div>
            </div>

            <div class="mt-10 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl border border-white/10 bg-white/6 p-5 shadow-2xl shadow-slate-950/20 backdrop-blur">
                    <p class="text-sm text-slate-400">Upcoming trips</p>
                    <div class="mt-3 flex items-end gap-2">
                        <span class="text-4xl font-semibold text-white">12</span>
                        <span class="pb-1 text-sm text-emerald-300">+3 this week</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-300">Trips are organized by departure date and destination.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/6 p-5 shadow-2xl shadow-slate-950/20 backdrop-blur">
                    <p class="text-sm text-slate-400">Bookings confirmed</p>
                    <div class="mt-3 flex items-end gap-2">
                        <span class="text-4xl font-semibold text-white">38</span>
                        <span class="pb-1 text-sm text-cyan-300">94% settled</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-300">Flights, hotels, and ground transport are ready to review at a glance.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/6 p-5 shadow-2xl shadow-slate-950/20 backdrop-blur">
                    <p class="text-sm text-slate-400">Shared travelers</p>
                    <div class="mt-3 flex items-end gap-2">
                        <span class="text-4xl font-semibold text-white">7</span>
                        <span class="pb-1 text-sm text-fuchsia-300">team active</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-300">Invite friends and keep everyone aligned on the same itinerary.</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/6 p-5 shadow-2xl shadow-slate-950/20 backdrop-blur">
                    <p class="text-sm text-slate-400">Pending tasks</p>
                    <div class="mt-3 flex items-end gap-2">
                        <span class="text-4xl font-semibold text-white">5</span>
                        <span class="pb-1 text-sm text-amber-300">needs attention</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-300">Visa checks, packing lists, and payment reminders are waiting.</p>
                </div>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-[1.6fr_1fr]">
                <section class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-slate-950/20 backdrop-blur">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-white">Next departures</h2>
                            <p class="mt-1 text-sm text-slate-400">The next seven days are grouped by priority.</p>
                        </div>
                        <span class="rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-200">
                            On track
                        </span>
                    </div>

                    <div class="mt-6 space-y-4">
                        <article class="rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-cyan-400/30 hover:bg-white/8">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-white">Tokyo weekend escape</p>
                                    <p class="mt-1 text-sm text-slate-400">Flights, Shibuya hotel, and team dinner confirmed.</p>
                                </div>
                                <div class="text-sm text-cyan-200">Fri, 8:30 AM</div>
                            </div>
                        </article>

                        <article class="rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-fuchsia-400/30 hover:bg-white/8">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-white">Lisbon planning sprint</p>
                                    <p class="mt-1 text-sm text-slate-400">Museum passes and seaside transfers still need review.</p>
                                </div>
                                <div class="text-sm text-fuchsia-200">Sat, 2:15 PM</div>
                            </div>
                        </article>

                        <article class="rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-amber-400/30 hover:bg-white/8">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-white">Marrakesh arrival checklist</p>
                                    <p class="mt-1 text-sm text-slate-400">Airport pickup, riad address, and currency prep.</p>
                                </div>
                                <div class="text-sm text-amber-200">Mon, 11:00 AM</div>
                            </div>
                        </article>
                    </div>
                </section>

                <aside class="rounded-3xl border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-slate-950/20 backdrop-blur">
                    <h2 class="text-xl font-semibold text-white">Quick actions</h2>
                    <p class="mt-1 text-sm text-slate-400">Shortcuts for the most common planning tasks.</p>

                    <div class="mt-6 space-y-3">
                        <a href="#" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:bg-white/10">
                            <span class="text-sm font-medium text-white">Add destination</span>
                            <span class="text-slate-400">+</span>
                        </a>
                        <a href="#" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:bg-white/10">
                            <span class="text-sm font-medium text-white">Upload documents</span>
                            <span class="text-slate-400">↗</span>
                        </a>
                        <a href="#" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:bg-white/10">
                            <span class="text-sm font-medium text-white">Share itinerary</span>
                            <span class="text-slate-400">⤴</span>
                        </a>
                        <a href="#" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 transition hover:bg-white/10">
                            <span class="text-sm font-medium text-white">Build packing list</span>
                            <span class="text-slate-400">≡</span>
                        </a>
                    </div>

                    <div class="mt-6 rounded-2xl border border-cyan-400/20 bg-cyan-400/10 p-4">
                        <p class="text-sm font-semibold text-cyan-100">Travel pulse</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">
                            Everything is synced. Your next scheduled trip is ready for final checks.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('header_title', $trip->title)

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-float-up" 
      x-data="{
          activeTab: 'overview',
          showActivityModal: false,
        showActivityEditModal: false,
        showActivityDeleteModal: false,
        showInviteModal: false,
        showExpenseModal: false,
        showBudgetModal: false,
        showEditModal: false,
          showDeleteModal: false,
          showRemoveMemberModal: false,
          removingMemberId: null,
          removingMemberName: '',
        showCompleteModal: false,
        showQuickNotesEdit: false,
        openDay: null,
        editingActivity: null,
        deletingActivity: null,
        completingActivity: null,
        activityType: 'activity',
        activityForm: {
            title: '',
            date: '',
            start_time: '',
            end_time: '',
            location: '',
            notes: '',
            type: '',
            custom_type: ''
        },
        editingExpense: null,
        deletingExpense: null,
        editForm: {
            title: '',
            amount: '',
            category: ''
        }
     }"
    @keydown.escape.window="showActivityModal = false; showActivityEditModal = false; showActivityDeleteModal = false; showInviteModal = false; showExpenseModal = false; showBudgetModal = false; showEditModal = false; showDeleteModal = false; showRemoveMemberModal = false; showCompleteModal = false">

    {{-- Invitation Response Banner --}}
    @include('trips.partials.invitation-response-banner')

    {{-- Trip Header Section --}}
    @include('trips.partials.trip-header')

    {{-- Tabs Navigation (Premium Segmented Toggle) --}}
    @include('trips.tabs.tabs-navigation')

    {{-- Tab Contents --}}
    <div class="mt-6">

        {{-- Overview Tab --}}
        @include('trips.tabs.partials.overview')

        {{-- Itinerary Tab --}}
        @include('trips.tabs.partials.itinerary')

        {{-- Members Tab --}}
        @include('trips.tabs.partials.members')

        {{-- Budget Tab --}}
        @include('trips.tabs.partials.budget')

        {{-- Settlements Tab --}}
        @include('trips.tabs.partials.settlements')
        
    </div>

    
    {{-- Modals --}}
    
    {{-- Add Activity Modal --}}
    @include('trips.modals.add-activity')

    {{-- Edit Activity Modal --}}
    @include('trips.modals.edit-activity')

    {{-- Quick Notes Edit Modal --}}
    @include('trips.modals.quick-notes-edit')

    {{-- Delete Activity Confirmation Modal --}}
    @include('trips.modals.delete-activity-confirmation')

    {{-- Complete Activity Confirmation Modal --}}
    @include('trips.modals.complete-activity-confirmation')

    {{-- Invite Member Modal --}}
    @include('trips.modals.invite-member')

    {{-- Add Expense Modal --}}
    @include('trips.modals.add-expense')

    {{-- Add Budget Modal --}}
    @include('trips.modals.add-budget')

    {{-- Edit Expense Modal --}}
    @include('trips.modals.edit-expense')

    {{-- Remove Member Confirmation Modal --}}
    @include('trips.modals.remove-member-confirmation')

    {{-- Delete Expense Confirmation Modal --}}
    @include('trips.modals.delete-expense')

</div>
@endsection

@extends('layout')

@section('title', 'Employee Database')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h3 style="font-weight: 600; color: var(--text-muted);">Current Staff</h3>
    <a href="index.php?action=create" class="btn-add">+ Add Employee</a>
</div>

<div class="employee-list">
    @foreach ($employees as $e)
    <div class="employee-card">
        <div class="employee-info">
            <strong>{{ $e['name'] }}</strong>
            <div class="employee-title">{{ $e['title'] }}</div>
            
            <div class="skills-list">
                @foreach (explode(',', $e['skills']) as $skill)
                <span class="skill-tag">{{ trim($skill) }}</span>
                @endforeach
            </div>
        </div>
        
        <div class="actions">
            <a href="index.php?action=edit&id={{ $e['id'] }}">Edit Details</a>
            <a href="index.php?action=delete&id={{ $e['id'] }}" class="delete-link" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
        </div>
    </div>
    @endforeach
</div>

@if(empty($employees))
<div style="text-align: center; padding: 3rem; color: var(--text-muted);">
    <p>No employees found. Start by adding one!</p>
</div>
@endif

@endsection

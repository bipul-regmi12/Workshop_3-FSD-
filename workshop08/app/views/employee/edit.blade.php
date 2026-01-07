@extends('layout')

@section('title', 'Edit Employee')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="index.php" style="font-size: 0.9rem; color: var(--text-muted);">&larr; Back to List</a>
</div>

<h3 style="text-align: center; margin-bottom: 1.5rem; color: var(--text-main);">Update Employee Details</h3>

<form method="post" action="index.php?action=update">
    <input type="hidden" name="id" value="{{ $employee['id'] }}">

    <div class="form-group">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem;">Full Name</label>
        <input name="name" value="{{ $employee['name'] }}" required>
    </div>

    <div class="form-group">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem;">Job Title</label>
        <input name="title" value="{{ $employee['title'] }}" required>
    </div>

    <div class="form-group">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem;">Skills</label>
        <input name="skills" value="{{ $employee['skills'] }}" required>
    </div>

    <button type="submit" style="margin-top: 1rem;">Update Employee Record</button>
</form>
@endsection

@extends('layout')

@section('title', 'Create Employee')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="index.php" style="font-size: 0.9rem; color: var(--text-muted);">&larr; Back to List</a>
</div>

<h3 style="text-align: center; margin-bottom: 1.5rem; color: var(--text-main);">Add New Employee</h3>

<form method="post" action="index.php?action=store">
    <div class="form-group">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem;">Full Name</label>
        <input name="name" placeholder="e.g. John Doe" required>
    </div>

    <div class="form-group">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem;">Job Title</label>
        <input name="title" placeholder="e.g. Senior Developer" required>
    </div>

    <div class="form-group">
        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem;">Skills</label>
        <input name="skills" placeholder="e.g. PHP, Laravel, MySQL (comma separated)" required>
    </div>

    <button type="submit" style="margin-top: 1rem;">Save Employee Record</button>
</form>
@endsection
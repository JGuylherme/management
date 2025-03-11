<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'code' => 'required|string|unique:roles,code|regex:/^[A-Za-z]{3}[0-9]{4}$/',
            'name' => 'required|string|max:255',
        ]);

        Role::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);
        
        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'code' => 'required|string|unique:roles,code,' . $role->id . '|regex:/^[A-Za-z]{3}[0-9]{4}$/',
            'name' => 'required|string',
        ]);

        $role->update($request->only(['code', 'name']));

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');;
    }
}

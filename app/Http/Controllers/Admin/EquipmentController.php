<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function show(){
        $equipments = Equipment::all();
        return view('admin.equipments.equipments', ['equipments' => $equipments]);
    }

    public function create(){
        return view('admin.equipments.createEquipment');
    }

    public function edit(Equipment $equipment) {
        return view('admin.equipments.editEquipment', ['equipment' => $equipment]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'condition' => 'nullable|in:new,good,very good,excellent',
            'last_maintenance' => 'nullable|date',
            'available_number' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
            'guide' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Image validation
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('equipment_images', 'public');
        }

        Equipment::create([
            'name' => $request->name,
            'condition' => $request->condition,
            'last_maintenance_date' => $request->last_maintenance_date,
            'available_number' => $request->available_number,
            'description' => $request->description,
            'guide' => $request->guide,
            'image' => $imagePath,
        ]);

        return redirect()->route('equipment.show')->with('success', 'Equipment added successfully.');
    }

    public function update(Request $request, Equipment $equipment)
    {
        // Validate other fields
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'condition' => 'nullable|in:new,good,very good,excellent',
            'last_maintenance' => 'nullable|date',
            'available_number' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
            'guide' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Image validation
        ]);

        // Check if a new image has been uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if there's a new one
            if ($equipment->image) {
                Storage::delete('public/equipment_images/' . $equipment->image);
            }
            // Store the new image
            $data['image'] = $request->file('image')->store('equipment_images', 'public');
        } else {
            // Keep the old image if no new image is uploaded
            $data['image'] = $equipment->image;
        }

        // Update the equipment record
        $equipment->update($data);

        return redirect()->route('equipment.show')->with('success', 'Equipment Updated Successfully');
    }

    public function destroy(Equipment $equipment){
        $equipment->delete();
        return redirect(route('equipment.show'))->with('success', 'Equipment Deleted Successfully.');
    }
}

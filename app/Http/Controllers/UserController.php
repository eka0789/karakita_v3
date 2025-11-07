<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use App\Models\Classroom;

class UserController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'role'         => 'required|in:pengajar,siswa,orangtua',
            'birth_date'   => 'nullable|date',
            'address'      => 'nullable|string|max:255',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'parent_id'    => 'nullable|exists:users,id',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos/users', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->assignRole($validated['role']);

        return back()->with('success', '✅ Akun baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => "required|email|unique:users,email,{$user->id}",
            'password'     => 'nullable|min:6',
            'birth_date'   => 'nullable|date',
            'address'      => 'nullable|string|max:255',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'parent_id'    => 'nullable|exists:users,id',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos/users', 'public');
        }

        $user->update($validated);

        return back()->with('success', '✅ Data akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return back()->with('success', '🗑 Akun berhasil dihapus!');
    }

    public function importView()
{
    return view('admin.import');
}

public function downloadTemplate($role)
{
    $file = public_path("samples/template_{$role}.xlsx");

    if (!file_exists($file)) {
        return back()->with('error', '❌ Template belum tersedia!');
    }

    return response()->download($file);
}

public function importExcel(Request $request)
{
    $request->validate([
        'role' => 'required|in:pengajar,siswa,orangtua',
        'file' => 'required|mimes:xlsx,xls,csv|max:2048'
    ]);

    $rows = Excel::toArray([], $request->file('file'))[0] ?? [];

    if (empty($rows)) {
        return back()->with('error', '❌ File Excel kosong atau tidak terbaca!');
    }

    $header = collect($rows[0])->map(fn($h) => strtolower(trim($h)))->toArray();
    $count = 0;

    foreach (array_slice($rows, 1) as $row) {
        $data = @array_combine($header, $row);

        if (!$data || empty($data['email'])) continue;
        if (User::where('email', $data['email'])->exists()) continue;

        $classroomId = null;
        if (isset($data['class_name'])) {
            $class = Classroom::firstOrCreate(['name' => $data['class_name']]);
            $classroomId = $class->id;
        }

        $user = User::create([
            'name'        => $data['name'] ?? 'Tidak Bernama',
            'email'       => $data['email'],
            'password'    => Hash::make('12345678'), // default password
            'role'        => $request->role,
            'birth_date'  => $data['birth_date'] ?? null,
            'address'     => $data['address'] ?? null,
            'classroom_id'=> $classroomId
        ]);

        $user->assignRole($request->role);
        $count++;
    }

    return back()->with('success', "✅ Import Selesai! $count pengguna berhasil ditambahkan 🎯");
}
}

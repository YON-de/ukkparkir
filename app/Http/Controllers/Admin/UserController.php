<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('nama_lengkap')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username'     => 'required|string|unique:tb_user,username',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:admin,petugas,owner',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'status_aktif' => 1,
        ]);

        LogAktivitas::catat("Menambahkan user baru: {$request->username}");

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username'     => 'required|string|unique:tb_user,username,' . $user->id_user . ',id_user',
            'role'         => 'required|in:admin,petugas,owner',
            'password'     => 'nullable|string|min:6',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'role'         => $request->role,
            'status_aktif' => $request->has('status_aktif') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        LogAktivitas::catat("Mengupdate user: {$user->username}");

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->transaksis()->exists()) {
            $user->update(['status_aktif' => 0]);
            LogAktivitas::catat("Menonaktifkan user: {$user->username}");
            return redirect()->route('admin.users.index')
                             ->with('success', 'User dinonaktifkan karena punya riwayat transaksi.');
        }

        LogAktivitas::catat("Menghapus user: {$user->username}");
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus.');
    }
}
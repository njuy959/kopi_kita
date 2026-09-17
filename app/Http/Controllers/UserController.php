<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search nama atau email
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Form tambah user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in(['admin', 'cashier']),
            ],
        ]);

        // Hash password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in(['admin', 'cashier']),
            ],
        ]);

        // Password hanya diubah jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        // Tidak boleh menghapus akun yang sedang login
        if ((int) $user->id === (int) auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun yang sedang digunakan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek transaksi
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('transactions')) {
            $hasTransactions = DB::table('transactions')
                ->where('user_id', $user->id)
                ->exists();

            if ($hasTransactions) {
                return redirect()
                    ->route('users.index')
                    ->with(
                        'error',
                        'User tidak dapat dihapus karena sudah memiliki transaksi.'
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Cek riwayat stok
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('stock_histories')) {
            $hasStockHistories = DB::table('stock_histories')
                ->where('user_id', $user->id)
                ->exists();

            if ($hasStockHistories) {
                return redirect()
                    ->route('users.index')
                    ->with(
                        'error',
                        'User tidak dapat dihapus karena sudah memiliki riwayat stok.'
                    );
            }
        }

        // Hapus user
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
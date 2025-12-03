<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Vérifie si l'utilisateur est admin
     */
    private function isAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }
    }

    

    /**
     * Liste des utilisateurs
     */
    public function index()
    {
        $this->isAdmin();

        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher un utilisateur
     */
    public function show($id)
    {
        $this->isAdmin();

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit($id)
    {
        $this->isAdmin();

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, $id)
    {
        $this->isAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'tel'    => ['nullable', 'string', 'max:20'],
            'sexe'   => ['required', 'in:M,F'],
            'role'   => ['required', 'in:admin,user,moderateur'],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'tel'   => $request->tel,
            'sexe'  => $request->sexe,
            'role'  => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy($id)
    {
        $this->isAdmin();

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Mettre à jour le rôle
     */
    public function updateRole(Request $request, $id)
    {
        $this->isAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:admin,user,moderateur',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Rôle mis à jour.');
    }

    /**
     * Activer / désactiver un utilisateur
     */
    public function toggleStatus($id)
    {
        $this->isAdmin();

        $user = User::findOrFail($id);

        $user->active = !$user->active;
        $user->save();

        return back()->with('success', 'Statut mis à jour.');
    }


    /**
     * Liste des médecins
     */
    public function medecins()
    {
        $this->isAdmin();

        $medecins = User::where('role', 'medecin')->paginate(10);

        return view('admin.users.medecins', compact('medecins'));
    }

    /**
     * Liste des patients
     */
    public function patients()
    {
        $this->isAdmin();

        $patients = User::where('role', 'patient')->paginate(10);

        return view('admin.users.patients', compact('patients'));
    }
     public function patient()
    {

        $patients = User::where('role', 'patient')->paginate(10);

        return view('users.patients', compact('patients'));
    }
}

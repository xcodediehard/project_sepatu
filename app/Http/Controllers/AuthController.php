<?php

namespace App\Http\Controllers;

use App\Mail\ForPassMail;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //

    public function register_client()
    {
        $data = ["title" => "Registrasi"];
        return view("client.auth.contents.register", compact("data"));
    }

    public function register_client_process(Request $req)
    {
        $req->validate([
            "nama" => "required",
            "email" => "required|email|unique:pelanggans,email",
            "password" => "required|min:8",
            "alamat" => "required",
            "telfon" => "required|max:15",
            "confirm_password" => "required|min:8|same:password"
        ]);
        $list_value = [
            "nama" => $req->nama,
            "email" => $req->email,
            "password" => bcrypt($req->password),
            "alamat" => $req->alamat,
            "telfon" => $req->telfon,
            "haskey" => (string)Str::uuid()
        ];

        $process = Pelanggan::create($list_value);

        if ($process) {
            session()->flash('success', 'Anda berhasil melakukan register');
            return redirect()->route('user.login');
        } else {
            session()->flash('error', 'Data gagal melakukan register');
            return redirect()->route('user.register');
        }
    }

    public function login_client()
    {
        $data = ["title" => "Login"];
        return view("client.auth.contents.login", compact("data"));
    }

    public function login_client_process(Request $req)
    {
        $req->validate([
            "email" => "required|email|exists:pelanggans,email",
            "password" => "required|min:8"
        ]);
        $list_value = [
            "email" => $req->email,
            "password" => $req->password,
        ];

        if (Auth::guard("client")->attempt($list_value)) {
            session()->flash('success', 'Anda berhasil melakukan login');
            return redirect()->route('pages.home');
        } else {
            session()->flash('error', 'Data gagal melakukan login');
            return redirect()->route('user.login');
        }
    }

    public function forpass_client()
    {
        $data = ["title" => "Forgot Password"];
        return view("client.auth.contents.forpass", compact("data"));
    }

    public function forpass_client_process(Request $req)
    {
        $req->validate([
            "email" => "required|email|exists:pelanggans,email",
        ]);

        $process = Pelanggan::where("email", "=", $req->email)->first();

        if ($process !== null) {
            $list = [
                "email" => $process->email,
                "name" => $process->nama,
                "address" => route("user.verify", ["id" => $process->haskey])
            ];
            Mail::to($process->email)->send(new ForPassMail($list));
            session()->flash('success', 'Anda berhasil memproses forgot password');
            return redirect()->route('user.login');
        } else {
            session()->flash('success', 'Anda gagal memproses forgot password');
            return redirect()->route('user.forpass');
        }
    }

    public function verify_client($id)
    {
        $data = Pelanggan::where("haskey", "=", $id)->first();
        if ($data != null) {
            $data = [
                "title" => "Verify Password",
                "code" => $id
            ];
            return view("client.auth.contents.verify", compact("data"));
        } else {
            return redirect()->route("user.login");
        }
    }

    public function verify_client_process(Request $req)
    {
        $req->validate([
            "password" => "required|min:8",
            "code" => "required|exists:pelanggans,haskey",
            "confirm_password" => "required|min:8|same:password"
        ]);
        $list_value = [
            "haskey" => (string) Str::uuid(),
            "password" => bcrypt($req->password),
        ];

        $process = Pelanggan::where("haskey", "=", $req->code)->update($list_value);

        if ($process) {
            session()->flash('success', 'Anda berhasil melakukan pembaharuan password');
            return redirect()->route('user.login');
        } else {
            session()->flash('error', 'Data gagal melakukan pembaharuan password');
            return redirect()->route('user.login');
        }
    }

    public function logout_client()
    {
        Auth::guard("client")->logout();
        session()->flash('success', 'Anda baru saja melakukan logout');
        return redirect()->route('user.login');
    }



    public function login_admin()
    {
        $data = ["title" => "Login"];
        return view("admin.auth.contents.login", compact("data"));
    }

    public function login_admin_process(Request $req)
    {
        $req->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required|min:8"
        ]);
        $list_value = [
            "email" => $req->email,
            "password" => $req->password,
        ];

        if (Auth::guard("admin")->attempt($list_value)) {
            session()->flash('success', 'Anda berhasil melakukan login');
            return redirect()->route('staff.view');
        } else {
            session()->flash('error', 'Data gagal melakukan login');
            return redirect()->route('auth.login');
        }
    }

    public function forpass_admin()
    {
        $data = ["title" => "Forgot Password"];
        return view("admin.auth.contents.forpass", compact("data"));
    }

    public function forpass_admin_process(Request $req)
    {
        $req->validate([
            "email" => "required|email|exists:users,email",
        ]);

        $process = User::where("email", "=", $req->email)->first();

        if ($process !== null) {
            $list = [
                "email" => $process->email,
                "name" => $process->nama,
                "address" => route("auth.verify", ["id" => $process->haskey])
            ];
            Mail::to($process->email)->send(new ForPassMail($list));
            session()->flash('success', 'Anda berhasil memproses forgot password');
            return redirect()->route('auth.login');
        } else {
            session()->flash('success', 'Anda gagal memproses forgot password');
            return redirect()->route('auth.forpass');
        }
    }

    public function verify_admin($id)
    {
        $data = User::where("haskey", "=", $id)->first();
        if ($data != null) {
            $data = [
                "title" => "Verify Password",
                "code" => $id
            ];
            return view("admin.auth.contents.verify", compact("data"));
        } else {
            return redirect()->route("auth.login");
        }
    }

    public function verify_admin_process(Request $req)
    {
        $req->validate([
            "password" => "required|min:8",
            "code" => "required|exists:users,haskey",
            "confirm_password" => "required|min:8|same:password"
        ]);
        $list_value = [
            "haskey" => (string) Str::uuid(),
            "password" => bcrypt($req->password),
        ];

        $process = User::where("haskey", "=", $req->code)->update($list_value);

        if ($process) {
            session()->flash('success', 'Anda berhasil melakukan pembaharuan password');
            return redirect()->route('auth.login');
        } else {
            session()->flash('error', 'Data gagal melakukan pembaharuan password');
            return redirect()->route('auth.login');
        }
    }

    public function logout_admin()
    {
        Auth::guard("admin")->logout();
        session()->flash('success', 'Anda baru saja melakukan logout');
        return redirect()->route('auth.login');
    }
}

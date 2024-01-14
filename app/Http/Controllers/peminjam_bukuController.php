<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Main;
use Exception;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Session;
// use illuminate\contract\Mailer;
use Illuminate\Support\Facades\Mail;
use App\Http\Controller\DB;
use App\Models\peminjam_bukuModel;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Koleksi;

class peminjam_bukuController extends Controller
{

    //INI UNTUK REDIRECT
    public function session_login(Request $req)
    {
        $login = Session::get('login');
        if ($login != '') {
            Session::put('login', $login);
            return view('/koleksi');
        } else {
            return redirect('/login');
        }
    }

    //INI UNTUK LOGIN
    public function send_login(Request $request)
    {
        session_start();

        //mengambil value text box

        $loginMail = $request->input('username');
        $loginPass = $request->input('password');

        $tboxLogin = [
            'username' => $loginMail,
            'password' => $loginPass
        ];

        $sambungKeModel = new peminjam_bukuModel;

        $loginCountCheck = $sambungKeModel->cekLogin($tboxLogin);

        if ($loginCountCheck) {

            Session::flash('success', 'Anda berhasil login');

            return redirect('/input_peminjam');
        } else {
            Session::flash('loginError', 'Email atau password salah.');
            return redirect('/login');
        }
    }

    //LOGIN INDEX
    public function loginIndex()
    {
        return view('/login', [
            'title' => 'login',
            'active' => 'login'
        ]);
    }

    //Untuk display Semua Buku
    public function send_semuaBuku()
    {
        //Variabel untuk nyambung ke model
        $anggota = new peminjam_bukuModel;
        $semuaBuku = $anggota->get_semuaBuku();
        //return hasil dari model
        return view('koleksi', ['semuaBuku' => $semuaBuku]);
    }

    // ini untuk insert Peminjam Buku
    public function send_insertpeminjam(request $request)
    {
        //mengambil value text box 
        $insertkode_peminjam = $request->input('kode_peminjam');
        $insertkode_koleksi = $request->input('kode_koleksi');
        $insertkode_anggota = $request->input('kode_anggota');
        $inserttanggal_pinjam = $request->input('tanggal_pinjam');
        $inserttanggal_kembali = $request->input('tanggal_kembali');

        $sambungpostinsert = new peminjam_bukuModel();

        $tboxinsertpeminjam = [
            'insertkode_peminjam' => $insertkode_peminjam,
            'insertkode_koleksi' => $insertkode_koleksi,
            'insertkode_anggota' => $insertkode_anggota,
            'inserttanggal_pinjam' => $inserttanggal_pinjam,
            'inserttanggal_kembali' => $inserttanggal_kembali
        ];
        // $loggedInIdUpdate = Session::get('id');

        $checkinsert = $sambungpostinsert->post_insert($tboxinsertpeminjam);

        if ($checkinsert == 1) {


            Session::flash('success', 'Anda berhasil menambahkan admin baru');
            return redirect('/input_peminjam');

            // Session::flash('insertpeminjamerror', 'Mohon lengkapi Textbox yang kosong.');
        } else {
            Session::flash('insertpeminjamerror', 'Maaf input anda tidak berhasil.');
            return redirect('/input_peminjam');
        }
    }

    //Untuk display Semua Buku
    public function send_semuapeminjam()
    {
        //Variabel untuk nyambung ke model
        $peminjam = new peminjam_bukuModel;
        $semuaPeminjam = $peminjam->get_semuaPeminjam();
        //return hasil dari model
        return view('history_peminjam', ['semuaPeminjam' => $semuaPeminjam]);
    }

    // untuk update anggota
    public function send_updateanggota(request $request)
    {
        $insertkode_anggota = $request->input('kode_anggota');
        $insertalamat = $request->input('alamat');
        $insertno_hp = $request->input('no_hp');

        $sambungpostupdate = new peminjam_bukuModel();

        $tboxupdateanggota = [
            'insertkode' => $insertkode_anggota,
            'insertalamat' => $insertalamat,
            'insertno_hp' => $insertno_hp
        ];


        $sambungpostupdate->post_update($tboxupdateanggota);
        return redirect('/input_peminjam');
    }

    // ini untuk insert buku baru
    public function send_insertbuku(request $request)
    {
        //mengambil value text box 
        $insertkode_koleksi = $request->input('kode_koleksi');
        $insertjudul = $request->input('judul');
        $insertpenulis = $request->input('penulis');
        $insertpenerbit = $request->input('penerbit');
        $inserttahun_terbit = $request->input('tahun_terbit');
        $insertjumlah_buku = $request->input('jumlah_buku');

        $sambungpostinsert = new peminjam_bukuModel();

        $tboxinsertbuku = [
            'insertkode_koleksi' => $insertkode_koleksi,
            'insertjudul' => $insertjudul,
            'insertpenulis' => $insertpenulis,
            'insertpenerbit' => $insertpenerbit,
            'inserttahun_terbit' => $inserttahun_terbit,
            'insertjumlah_buku' => $insertjumlah_buku
        ];
        // $loggedInIdUpdate = Session::get('id');

        $checkinsert = $sambungpostinsert->post_insertBuku($tboxinsertbuku);

        if ($checkinsert == 1) {


            Session::flash('success', 'Anda berhasil menambahkan admin baru');
            return redirect('/input_peminjam');

            // Session::flash('insertbukuerr', 'Mohon lengkapi Textbox yang kosong.');
        } else {
            Session::flash('insertbukuerror', 'Maaf input anda tidak berhasil.');
            return redirect('/insert_buku');
        }
    }

    // untuk kembalikan buku yang dipinjam
    public function send_kembalikanbuku(request $request)
    {
        $insertkode_peminjam = $request->input('kode_peminjam');

        $sambungpostupdate = new peminjam_bukuModel();

        $tboxpengembalianbuku = [
            'insertkode_peminjam' => $insertkode_peminjam,
        ];


        $sambungpostupdate->post_pengembalianbuku($tboxpengembalianbuku);
        return redirect('/input_peminjam');
    }
}

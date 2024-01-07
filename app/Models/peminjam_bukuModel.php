<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\peminjam_bukuController;


class peminjam_bukuModel extends Model
{
    //login staff
    public function cekLogin($tboxLogin)
    {
        $queryCekLogin = "select * from `admin` WHERE username = :username AND `password` = :password";
        $executeQueryCekLogin = DB::select($queryCekLogin, $tboxLogin);

        // if ($executeQueryCekLogin[0]->is_exist == 1) {
        //     return true;
        // }
        // return false;

        if (isset($executeQueryCekLogin) && count($executeQueryCekLogin) > 0) {
            return $executeQueryCekLogin;
        }
        return null;
    }

    //Untuk Display semua Buku
    function get_semuaBuku()
    {
        $querySemuaBuku = "SELECT judul_buku, penulis, penerbit, tahun_terbit, stok_buku FROM koleksi ORDER BY judul_buku ASC;";
        $executequerySemuaBuku = DB::select($querySemuaBuku);
        return $executequerySemuaBuku;
    }

    //Untuk insert peminjam buku
    function post_insert($tboxinsertpeminjam)
    {

        $queryinsert = "INSERT INTO peminjaman( `kode_peminjaman`, `kode_koleksi`, `kode_anggota`, `tanggal_pinjam`, `tanggal_harus_kembali`) VALUES (:insertkode_peminjam, :insertkode_koleksi, :insertkode_anggota, :inserttanggal_pinjam, :inserttanggal_kembali)";

        $executequeryinsert = DB::insert($queryinsert, $tboxinsertpeminjam);
        // dd($executequeryupdate);
        return $executequeryinsert;
    }

    function get_semuaPeminjam()
    {
        $querySemuaPeminjam = "SELECT peminjaman.kode_peminjaman, anggota.nama_anggota, koleksi.judul_buku, peminjaman.tanggal_pinjam, peminjaman.tanggal_harus_kembali FROM peminjaman INNER JOIN anggota ON peminjaman.kode_anggota = Anggota.kode_anggota
        INNER JOIN koleksi ON peminjaman.kode_koleksi = koleksi.kode_koleksi;";
        $executequerySemuaPeminjam = DB::select($querySemuaPeminjam);
        return $executequerySemuaPeminjam;
    }

    // buat Query Update di page update anggota
    function post_update($tboxupdatemenu)
    {
        $cmd = "UPDATE anggota SET alamat_anggota = :insertalamat, no_telepon = :insertno_hp WHERE kode_anggota = :insertkode";
        $result = DB::update($cmd, $tboxupdatemenu);
        // dd($result);
        return $result;
    }

    function post_insertBuku($tboxinsertbuku)
    {

        $queryinsertbuku = "INSERT INTO koleksi( `kode_koleksi`, `judul_buku`, `penulis`, `penerbit`, `tahun_terbit`, `stok_buku`) VALUES (:insertkode_koleksi, :insertjudul, :insertpenulis, :insertpenerbit, :inserttahun_terbit, :insertjumlah_buku)";

        $executequeryinsert = DB::insert($queryinsertbuku, $tboxinsertbuku);
        // dd($executequeryupdate);
        return $executequeryinsert;
    }
}

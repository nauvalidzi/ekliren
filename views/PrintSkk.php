<?php

namespace PHPMaker2021\eclearance;

// Page object
$PrintSkk = &$Page;
?>
<?php
    $id = !empty(Get('id')) ? Get("id") : die ;

    function tanggal_surat($tanggal, $atas='ya', $acc=null) {
        if (empty($tanggal)) {
            return;
        }

        if ($atas == 'ya') {
            return date('m/Y', strtotime($tanggal));
        }

        if ($atas == 'tidak' && $acc == 'acc') {
            return tgl_indo($tanggal);
        }

        if ($atas == 'tidak') {
            return "       ".tgl_indo($tanggal, "yes");
        }

        return tgl_indo($tanggal);
    }
    
    function cek_tanggal($date) {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return true;
        }
    
        return false;
    }

    $data = ExecuteRow("SELECT skk.nomor_surat,
                            skk.nama, 
                            skk.nip, 
                            skk.nrp, 
                            skk.pangkat, 
                            skk.jabatan, 
                            skk.tanggal_request, 
                            skk.acc, 
                            p.pangkat AS nama_pangkat, 
                            j.nama_jabatan, 
                            sk.satuan_kerja AS nama_organisasi, 
                            k.keperluan AS detail_keperluan,
                            hkd.jenis_hukuman,
                            hkd.hukuman,
                            hkd.pasal,
                            hkd.surat_keputusan, 
                            hkd.sk_nomor,
                            hkd.tanggal_sk,
                            hkd.status_hukuman,
                            hkd.pernah_dijatuhi_hukuman,
                            bd.sk_banding_nomor, 
                            bd.tgl_sk_banding,
                            ins.pelanggaran_disiplin,
                            ins.inspeksi_kasus,
                            skp.tempat_sidang_kode_perilaku, 
                            skp.hukuman_administratif, 
                            skp.sidang_kode_perilaku_jaksa, 
                            skp.sk_nomor_kode_perilaku, 
                            skp.tgl_sk_kode_perilaku,
                            skp.status_hukuman_kode_perilaku
                            FROM data_request_skk skk 
                            LEFT JOIN m_pangkat p ON skk.pangkat = p.id 
                            LEFT JOIN m_jabatan j ON skk.jabatan = j.id 
                            LEFT JOIN m_satuan_kerja sk ON skk.unit_organisasi = sk.id 
                            LEFT JOIN m_keperluan k ON skk.keperluan = k.id 
                            LEFT JOIN (
                                SELECT pid_request_skk, jenis_hukuman, hukuman, pasal, sk.title as surat_keputusan, sk_nomor, tanggal_sk, status_hukuman, pernah_dijatuhi_hukuman
                                FROM hukuman_disiplin hkd
                                JOIN m_surat_keputusan sk ON hkd.surat_keputusan = sk.id
                            ) hkd ON skk.id_request = hkd.pid_request_skk
                            LEFT JOIN banding bd ON skk.id_request = bd.pid_request_skk
                            LEFT JOIN inspeksi ins ON skk.id_request = ins.pid_request_skk
                            LEFT JOIN (
                                SELECT pid_request_skk, sk.satuan_kerja as tempat_sidang_kode_perilaku, hukuman_administratif, sidang_kode_perilaku_jaksa, sk_nomor_kode_perilaku, tgl_sk_kode_perilaku, status_hukuman_kode_perilaku
                                FROM sidang_kode_perilaku skp
                                JOIN m_satuan_kerja sk ON skp.tempat_sidang_kode_perilaku = sk.id
                            ) skp ON skk.id_request = skp.pid_request_skk
                            WHERE skk.id_request = {$id}");

    $nomor_surat = $data['nomor_surat'] > 0 ? $data['nomor_surat'] : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    if (empty($data['acc'])) {
        $kopBulanTahun = tanggal_surat($data['tanggal_request']);
        $ttdBulanTahun = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".tanggal_surat($data['tanggal_request'], 'tidak');
    } else {
        $kopBulanTahun = tanggal_surat($data['acc']);
        $ttdBulanTahun = tanggal_surat($data['acc'], 'tidak', 'acc');
    }

    $keySignature = Get("signature") == 'true' ? "<td class=\"my-3\"><img src=\"".base_url('images/logoEsign.png')."\" width=\"125\"></td>" : "<td class=\"my-5\"></td>";

    if (Get('initials') == 'true') {
        $pemeriksa = ExecuteScalar("SELECT config_value FROM konfigurasi WHERE config_name = 'pemeriksa_paraf'");
        $pemeriksa = $pemeriksa ? "<img src=\"".base_url('files/'.$pemeriksa)."\" height=\"50\" style=\"vertical-align:middle;\">" : '';
        $aswas = ExecuteScalar("SELECT config_value FROM konfigurasi WHERE config_name = 'aswas_paraf'");
        $aswas = $aswas ? "<img src=\"".base_url('files/'.$aswas)."\" height=\"50\" style=\"vertical-align:middle;\">" : '';
    } else {
        $pemeriksa = null;
        $aswas = null;
    }

    $kajati_nama = ExecuteScalar("SELECT config_value FROM konfigurasi WHERE config_name = 'kajati_nama'");
    $kajati_jabatan = ExecuteScalar("SELECT config_value FROM konfigurasi WHERE config_name = 'kajati_jabatan_nip'");

    $poin_1 = [
        "Tidak pernah dijatuhi Hukuman Disiplin/pernah dijatuhi hukuman disiplin ringan/sedang/berat",
        "----NIHIL----",
        "----NIHIL----",
        "----NIHIL----",
        "----NIHIL----",
        "----NIHIL----",
        "selesai/sedang/belum *)"
    ];

    if ($data['pernah_dijatuhi_hukuman'] == 'Ya') {
        $poin_1 = [
            "Pernah dijatuhi hukuman disiplin " . $data['jenis_hukuman'],
            $data['hukuman'],
            $data['pasal'],
            $data['surat_keputusan'],
            $data['sk_nomor'],
            cek_tanggal($data['tanggal_sk']) ? tgl_indo($data['tanggal_sk']) : '----NIHIL----',
            $data['status_hukuman']
        ];
    }

    $poin_2 = [
        "----NIHIL----",
        "----NIHIL----",        
    ];

    if ($data['pernah_dijatuhi_hukuman'] == 'Ya') {
        $poin_2 = [
            $data['sk_banding_nomor'],
            cek_tanggal($data['tgl_sk_banding']) ? tgl_indo($data['tgl_sk_banding']) : '----NIHIL----',
        ];
    }

    $poin_3 = empty($data['inspeksi_kasus']) || $data['inspeksi_kasus'] == 'Tidak' ? "----NIHIL----" : $data['pelanggaran_disiplin'];

    $poin_4 = [
        "----NIHIL----",
        "----NIHIL----",
        "----NIHIL----",
        "----NIHIL----",
        "selesai/sedang"
    ];

    if ($data['sidang_kode_perilaku_jaksa'] == 'Ya') {
        $poin_4 = [
            $data['tempat_sidang_kode_perilaku'],
            $data['hukuman_administratif'],
            $data['sk_nomor_kode_perilaku'],
            cek_tanggal($data['tanggal_sk']) ? tgl_indo($data['tgl_sk_kode_perilaku']) : '----NIHIL----',
            $data['status_hukuman_kode_perilaku'],
        ];
    }
    // print_r($poin_4); die;

    use Dompdf\Dompdf;

    // require 'vendor/autoload.php';

    ob_get_clean(); // don't forget this at the beginning
    // instantiate and use the dompdf class
    $dompdf = new Dompdf(['enable_remote' => true]);

    // $options = $dompdf->getOptions(); 
    // $options->set(array('isRemoteEnabled' => true));
    // $dompdf->setOptions($options);
    $html = "<link rel=\"stylesheet\" href=\"".base_url('bootstrap4/css/bootstrap.min.css')."\" />
            <style>                
                html { 
                    margin: 34px 76px;
                    width: 500px;
                }
                table { width: 100% auto; }
                .heading-kop1 { font-size: 18px; line-height: normal; color: #000;}
                .heading-kop2 { font-size: 23px; line-height: normal; color: #000;}
                .heading-kop3 { font-size: 14px; line-height: normal; color: #000;}
                .letter-heading { font-size: 16px; line-height: normal; color: #000;}
                .letter-body { font-size: 15.5px; line-height: normal; color: #000;}
                .letter-tembusan { font-size: 12.5px; line-height: 90%; color: #000;}
                hr { border-top: 1.2px solid #000; margin: 3px; }
                .line-strict { line-height: 80%; }
            </style>";

    $html .= "<table>
                <tr>
                    <td width=\"20%\" align=\"center\"><img src=\"".base_url('images/logo-cetak-sktm.png')."\" width=\"110\"></td>
                    <td>
                        <p class=\"text-center my-0 heading-kop1 font-weight-bold\">KEJAKSAAN REPUBLIK INDONESIA</p>
                        <p class=\"text-center m-0 heading-kop2 font-weight-bold\">KEJAKSAAN TINGGI JAWA TIMUR</p>
                        <p class=\"text-center m-0 heading-kop3 font-weight-bold\">Jalan Jenderal Ahmad Yani No. 54-56, Kota Surabaya, Jawa Timur 60235</p>
                        <p class=\"text-center m-0 heading-kop3 font-weight-bold\">Telp. (031) 8290577 fax. (031) 8293826, http://kejati-jatim.go.id</p>
                        <p class=\"text-center m-0 heading-kop3 font-weight-bold\">Email : pengawasankejatijatim@gmail.com</p>
                    </td>
                </tr>
            </table>
            <hr>
            <table class=\"mt-2\">
                <tr>
                    <td class=\"text-right font-weight-bolder\">WAS-38</td>
                </tr>
            </table>
            <table class=\"mt-3 mb-2\">
                <tr>
                    <td class=\"font-weight-bolder text-center line-strict\"><u>SURAT KETERANGAN KEPEGAWAIAN</u></td>
                </tr>
                <tr>
                    <td class=\"text-center letter-heading\">Nomor: R-{$nomor_surat}/M.5/Hkt.1/{$kopBulanTahun}</td>
                </tr>
            </table>
            <table class=\"mt-4 letter-body\">
                <tr>
                    <td class=\"text-justify\" colspan=\"3\" width=\"100%\">----------Berdasarkan hasil penelitian data/dokumen pada Bidang Pengawasan/Asisten Pengawasan, bahwa : ---------------------------------------------------------------------------------------------</td>
                </tr>
                <tr>
                    <td width=\"5%\">1. </td>
                    <td width=\"25%\">Nama</td>
                    <td width=\"70%\">: {$data['nama']}</td>
                </tr>
                <tr>
                    <td width=\"5%\">2. </td>
                    <td width=\"25%\">Pangkat</td>
                    <td width=\"70%\">: {$data['nama_pangkat']}</td>
                </tr>
                <tr>
                    <td width=\"5%\">3. </td>
                    <td width=\"25%\">NRP/NIP</td>
                    <td width=\"70%\">: {$data['nrp']} / {$data['nip']}</td>
                </tr>
                <tr>
                    <td width=\"5%\">4. </td>
                    <td width=\"25%\">Jabatan</td>
                    <td width=\"70%\">: {$data['nama_jabatan']}</td>
                </tr>
                <tr>
                    <td width=\"5%\">5. </td>
                    <td width=\"25%\">Unit Organisasi</td>
                    <td width=\"70%\">: {$data['nama_organisasi']}</td>
                </tr>
                <tr>
                    <td width=\"5%\">6. </td>
                    <td width=\"25%\">Keperluan</td>
                    <td width=\"70%\">: {$data['detail_keperluan']}</td>
                </tr>
            </table>
            <table class=\"mt-3 letter-body\">
                <tr>
                    <td colspan=\"2\" class=\"text-justify\">Pada saat diterbitkan Surat Keterangan Kepegawaian ini, yang bersangkutan dalam keadaan sebagai berikut :
                    </td>
                </tr>
                <tr>
                    <td width=\"5%\" class=\"align-baseline\">1. </td>
                    <td width=\"95%\" class=\"text-justify\">{$poin_1['0']} berupa {$poin_1['1']} melanggar Pasal {$poin_1['2']} berdasarkan Surat Keputusan {$poin_1['3']} Nomor : {$poin_1['4']} Tanggal {$poin_1['5']} dengan catatan Hukuman Disiplin dimaksud telah {$poin_1['6']} dijalankan.</td>
                </tr>
                <tr>
                    <td width=\"5%\" class=\"align-baseline\">2. </td>
                    <td width=\"95%\" class=\"text-justify\">Sedang mengajukan keberatan/banding administratif *) terhadap penjatuhan hukuman disiplin berdasarkan Surat Keputusan Nomor : {$poin_2['0']} Tanggal : {$poin_2['1']}.</td>
                </tr>
                <tr>
                    <td width=\"5%\" class=\"align-baseline\">3. </td>
                    <td width=\"95%\" class=\"text-justify\">Sedang dilakukan Inspeksi Kasus karena diduga melakukan pelanggaran disiplin yaitu : {$poin_3}.</td>
                </tr>
                <tr>
                    <td width=\"5%\" class=\"align-baseline\">4. </td>
                    <td width=\"95%\" class=\"text-justify\">Sedang dilakukan sidang Kode Perilaku Jaksa di {$poin_4['0']} pernah dijatuhi hukuman administratif oleh Majelis Kode Perilaku Jaksa berupa {$poin_4['1']} berdasarkan Surat Keputusan Nomor : {$poin_4['2']} Tanggal {$poin_4['3']} tentang Hukuman Administratif *) dengan catatan Hukuman Administratif dimaksud telah {$poin_4['4']} *) dijalankan.</td>
                </tr>
            </table>
            <table class=\"mt-2 letter-body\">
                <tr>
                    <td colspan=\"2\" class=\"text-justify\">----------Demikian Surat Keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.------------------------------------------------------------------------------------------------------------</td>
                </tr>
            </table>
            <table class=\"mt-3\">
                <tr>
                    <td width=\"40%\"></td>
                    <td width=\"60%\" class=\"text-center\">
                        <table class=\"letter-body\">
                            <tr><td>Surabaya, {$ttdBulanTahun}</td></tr>
                            <tr><td>{$aswas} <span style=\"vertical-align:middle;\">Kepala Kejaksaan Tinggi Jawa Timur</span> {$pemeriksa}</td></tr>
                            <tr>{$keySignature}</tr>
                            <tr><td class=\"font-weight-bolder line-strict\"><u>{$kajati_nama}</u></td></tr>
                            <tr><td>{$kajati_jabatan}</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class=\"letter-tembusan mt-1\">
                <tr>
                    <td>Tembusan :</td>
                    <td></td>
                </tr>
                <tr>
                    <td>1. Yth. Jaksa Agung Muda Pengawasan</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2. A r s i p</td>
                    <td></td>
                </tr>
            </table>";
    
    // ob_start();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    ob_end_clean(); 

    // Output the generated PDF to Browser
    $dompdf->stream('print_skk_' . $data['nip'], ['Attachment' => false]);  
?>

<?= GetDebugMessage() ?>

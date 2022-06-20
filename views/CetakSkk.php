<?php

namespace PHPMaker2021\eclearance;

// Page object
$CetakSkk = &$Page;
?>
<?php
	die();
	function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);

    	$pecahkan = explode('-', $tanggal);
        if (!is_array($pecahkan)) {

    		// variabel pecahkan 0 = tanggal
    		// variabel pecahkan 1 = bulan
    		// variabel pecahkan 2 = tahun
    		return $pecahkan[2] . ' ' .  $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        }

        return '<i><small>(data tanggal belum diisi)</small></i>';	
	}

    function tanggal_surat($tanggal, $atas='ya') {
        if (empty($tanggal) && $atas == 'ya') {
            return date('m/Y');
        } else {
            return date('m/Y', strtotime($tanggal));
        }

        if (empty($tanggal) && $atas == 'tidak') {
            return date('F Y');
        } else {
            return tgl_indo($data['acc']);
        }
    }

    function acc_aswas($status, $acc=null) {
        if ($status == 'Request Dikirim ke Kajati' && empty($acc)) {
            return '<img src="images/aswas.png" width="20" style="margin-left: -1.5em;"> ';
        }

        return null;
    }

    function acc_pemeriksa($status, $acc=null) {
        if (($status == 'Request Dikirim ke Aswas' || $status == 'Request Dikirim ke Kajati') && empty($acc)) {
            return ' <img src="images/pemeriksa.png" width="20">';
        }

        return null;
    }
	
	$id = Get("id_request_sktm");
	$data = ExecuteRow("SELECT data_request_sktm.id_request_sktm AS id_request_sktm,
	data_request_sktm.nomor_surat AS nomor_surat, data_request_sktm.nama AS nama, data_request_sktm.nip AS nip,
	data_request_sktm.nrp AS nrp, data_request_sktm.pangkat AS pangkat,
	data_request_sktm.jabatan AS jabatan,
    data_request_sktm.unit_organisasi AS unit_organisasi,
    data_request_sktm.tanggal_request AS tanggal_request,
    data_request_sktm.scan_lhkpn AS scan_lhkpn,
    data_request_sktm.scan_lhkasn AS scan_lhkasn,
    data_request_sktm.kategori_pemohon AS kategori_pemohon,
    data_request_sktm.keperluan AS keperluan, data_request_sktm.keterangan AS keterangan,
    data_request_sktm.status AS status, data_request_sktm.acc AS acc,
    hukuman_disiplin.jenis_hukuman AS jenis_hukuman, hukuman_disiplin.hukuman AS
    hukuman, hukuman_disiplin.pasal AS pasal, hukuman_disiplin.sk_nomor AS
    sk_nomor, hukuman_disiplin.tanggal_sk AS tanggal_sk,
    hukuman_disiplin.status_hukuman AS status_hukuman,
    hukuman_disiplin.pernah_dijatuhi_hukuman AS pernah_dijatuhi_hukuman,
    banding.sk_banding_nomor AS sk_bandng_nomor, banding.tgl_sk_banding AS
    tgl_sk_banding, banding.mengajukan_keberatan_banding AS
    mengajukan_keberatan_banding, inspeksi.pelanggaran_disiplin AS
    pelanggaran_disiplin, inspeksi.inspeksi_kasus AS inspeksi_kasus,
    sidang_kode_perilaku.tempat_sidang_kode_perilaku AS
    tempat_sidang_kode_perilaku, sidang_kode_perilaku.hukuman_administratif AS
    hukuman_administratif, sidang_kode_perilaku.sidang_kode_perilaku_jaksa AS
    sidang_kode_perilaku_jaksa, sidang_kode_perilaku.sk_nomor_kode_perilaku AS
    sk_nomor_kode_perilaku, sidang_kode_perilaku.tgl_sk_kode_perilaku AS
    tgl_sk_kode_perilaku, sidang_kode_perilaku.status_hukuman_kode_perilaku AS
    status_hukuman_kode_perilaku, m_pangkat.pangkat AS nama_pangkat, m_jabatan.nama_jabatan,
    sk.satuan_kerja AS nama_organisasi, m_keperluan.keperluan AS detail_keperluan, sk2.satuan_kerja AS tempat_sidang
  FROM ((((((((data_request_sktm 
  LEFT JOIN hukuman_disiplin ON data_request_sktm.id_request_sktm = hukuman_disiplin.pid_request_sktm) 
  LEFT JOIN banding ON data_request_sktm.id_request_sktm = banding.pid_request_sktm)
  LEFT JOIN inspeksi ON data_request_sktm.id_request_sktm = inspeksi.pid_request_sktm)
  LEFT JOIN sidang_kode_perilaku ON data_request_sktm.id_request_sktm = sidang_kode_perilaku.pid_request_sktm) 
  LEFT JOIN m_pangkat ON data_request_sktm.pangkat = m_pangkat.id_pangkat) 
  LEFT JOIN m_jabatan ON data_request_sktm.jabatan = m_jabatan.id_jabatan)
  LEFT JOIN m_satuan_kerja sk ON data_request_sktm.unit_organisasi = sk.id)
  LEFT JOIN m_satuan_kerja sk2 ON sidang_kode_perilaku.tempat_sidang_kode_perilaku = sk2.id)
  LEFT JOIN m_keperluan ON data_request_sktm.keperluan = m_keperluan.id_keperluan
  WHERE data_request_sktm.id_request_sktm = '$id'");

?>

    <table border="0" align="center">
        <tr>
        <td><img src="images/logo2.png" width="70" height="87" alt=""></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
            <td>
              <center>
                <p align="center"><strong>KEJAKSAAN REPUBLIK INDONESIA</strong><br>
                    <font size="5">KEJAKSAAN TINGGI JAWA TIMUR</font><br>
                    <font size="2">Jl. A. Yani No. 54-56, Kota Surabaya, Jawa Timur 60235</font><br>
					<font size="2">Telp. (031) 8290577 fax. (031) 8293826, http://kejati-jatim.go.id</font><br>
                </p>
                </center>
            </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
        <tr>
            <td colspan="45"><hr color="black"></td>
        </tr>
    </table>
    <table>
        <tr>
            <td><p style="margin-left: 65em;">WAS-38</p></td>
        </tr>
    </table>
    <br>
    <table border="0" align="center">
        <tr>
            <td>
                <center>
                    <font size="4"><b>SURAT KETERANGAN KEPEGAWAIAN</b></font><br>
                    <hr style="margin:0px" color="black">
                    <span>Nomor : R-<?= ($data['nomor_surat'] > 0) ? $data['nomor_surat'] : '-' ?>/M.5/Hkt.1/<?= tanggal_surat($data['acc']) ?></span>
                </center>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table border="0" align="center">
        <tr>
            <td>
                
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan hasil penelitian data/dokumen pada Bidang Pengawasan/Asisten Pengawasan, bahwa :
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table border="0" align="center">
                                        <tr>
                                            <td>Nama</td>
                                            <td>: </td>
                                            <td> <?php echo $data['nama'] ?></td>
                                        </tr>
										<tr>
                                            <td>Pangkat</td>
                                            <td>: </td>
                                            <td> <?php echo $data['nama_pangkat'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>NIP</td>
                                            <td>: </td>
                                            <td> <?php echo $data['nip'] ?> / <?php echo $data['nrp'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>: </td>
                                            <td> <?php echo $data['nama_jabatan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Unit Organisasi</td>
                                            <td>: </td>
                                            <td> <?php echo $data['nama_organisasi'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Keperluan</td>
                                            <td>: </td>
                                            <td style="display: inline-block;max-width: 600px"> <?php echo $data['detail_keperluan'] ?></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table border="0" align="center">
                                        <tr>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pada saat diterbitkan Surat Keterangan Kepegawaian ini, yang bersangkutan dalam keadaan sebagai berikut :</u></b>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table border="0" align="center" style="width: 700px; margin: 0 auto;">
                                        <tr>
                                            <td>
                                                <ol>
                                                    <li><?= ($data['pernah_dijatuhi_hukuman'] == 'Tidak' OR '') ? "Tidak pernah dijatuhi Hukuman Disiplin/<span style='text-decoration: line-through;'>pernah dijatuhi hukuman disiplin ringan/sedang/berat</span>" : "Pernah dijatuhi hukuman disiplin ".$data['jenis_hukuman'].""; ?> <?= ($data['pernah_dijatuhi_hukuman'] == 'Tidak' OR '') ? "berupa----NIHIL----" : "berupa ".$data['hukuman'].""; ?> <?= ($data['pernah_dijatuhi_hukuman'] == 'Tidak' OR '') ? "melanggar Pasal---NIHIL----" : "melangar Pasal ".$data['pasal'].""; ?> berdasarkan <?= ($data['pernah_dijatuhi_hukuman'] == 'Tidak' OR '') ? "Surat Keputusan Nomor:----NIHIL----Tanggal----NIHIL---- " : "Surat Keputusan Nomor ".$data['sk_nomor']." Tanggal ".tgl_indo($data['tanggal_sk']).""; ?> dengan catatan Hukuman Disiplin dimaksud telah <?= ($data['pernah_dijatuhi_hukuman'] == 'Tidak' OR '') ? "<span style='text-decoration: line-through;'>selesai/sedang/belum*)</span>" : "".$data['status_hukuman']."";?>*) dijalankan.</li>
                                                    <li>Sedang mengajukan keberatan/banding administratif *) terhadap penjatuhan hukuman disiplin berdasarkan Surat Keputusan Nomor : <?= ($data['mengajukan_keberatan_banding'] == 'Tidak' OR '') ? "---NIHIL--- Tanggal :  ---NIHIL---" : "".$data['sk_bandng_nomor']." Tanggal ".tgl_indo($data['tgl_sk_banding'])."";?></li>
                                                    <li>Sedang dilakukan Inspeksi Kasus karena diduga melakukan pelanggaran disiplin yaitu : <?= ($data['inspeksi_kasus'] == 'Tidak' OR '') ? "---NIHIL---" : "".$data['pelanggaran_disiplin'].""; ?>.</li>
                                                    <li>Sedang dilakukan sidang Kode Perilaku Jaksa di <?= ($data['sidang_kode_perilaku_jaksa'] == 'Tidak' OR '') ? "---NIHIL---" : "".$data['tempat_sidang'].""; ?> pernah dijatuhi hukuman administratif oleh Majelis Kode Perilaku Jaksa berupa <?= ($data['sidang_kode_perilaku_jaksa'] == 'Tidak' OR '') ? "---NIHIL---" : "".$data['hukuman_administratif'].""; ?> berdasarkan Surat Keputusan Nomor : <?= ($data['sidang_kode_perilaku_jaksa'] == 'Tidak' OR '') ? "---NIHIL---" : "".$data['sk_nomor_kode_perilaku'].""; ?> Tanggal <?= ($data['sidang_kode_perilaku_jaksa'] == 'Tidak' OR '') ? "---NIHIL---" : "".tgl_indo($data['tgl_sk_kode_perilaku']).""; ?> tentang Hukuman Administratif *) dengan catatan Hukuman Administratif dimaksud telah <?= ($data['sidang_kode_perilaku_jaksa'] == 'Tidak' OR '') ? "selesai/sedang" : "".$data['status_hukuman_kode_perilaku'].""; ?> *) dijalankan</li>
                                                    <li>Melaporkan LHKPN ke Komisi Pemberantasan Korupsi (KPK RI).</li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table border="0" align="center" style="width: 700px; margin: 0 auto;">
                                        <tr>
                                            <td>Demikian Surat Keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    <table border="0" align="center">
                                        <tr>
                                            <th width="0"></th>
                                            <th width="377"></th>
                                            <th width="432">Surabaya, <?= tanggal_surat($data['acc'], 'tidak') ?></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><?= acc_aswas($data['status'], $data['acc']) ?>Kepala Kejaksaan Tinggi Jawa Timur <?= acc_pemeriksa($data['status'], $data['acc']) ?>
                                        </tr>
                                        <tr>
                                            <td rowspan="15"></td>
                                            <td></td>
                                            <td rowspan="15"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr><tr>
                                            <td></td>
                                        </tr><tr>
                                            <td></td>
                                        </tr><tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><b><u>Dr. Mohamad Dofir, S.H., M.H.
Jaksa Utama Madya, NIP. 19641116 199203 1 001
)</u></b></td>
                                        </tr>
                                    </table>

<script>
  window.print();
</script>

<?= GetDebugMessage() ?>

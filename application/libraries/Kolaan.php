<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kolaan {

    function get_npsn($nomor)
    {
        $this->CI = & get_instance();
        $url = 'https://referensi.data.kemdikbud.go.id/tabs.php?npsn='.$nomor;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $source = curl_exec($ch);
        preg_match_all("'<td>(.*?)</td>'si", $source, $data);
        preg_match("'<td title=\"sumber\">(.*?)</td>'si", $source, $akreditasi);
        if (curl_errno($ch)) {
            return 'server error';
        }
        curl_close ($ch);
        $data = array(
            'npsn' => strip_tags($data[1][7]),
            'nama' => strip_tags($data[1][3]),
            'slug' => strtolower(str_replace(' ', '', strip_tags($data[1][3]))),
            'alamat' => strip_tags($data[1][11] . ', ' . $data[1][20] . ', ' . $data[1][24] . ', ' . $data[1][28] . ', ' . $data[1][32] . ' ' . $data[1][15]),
            'akreditasi' => strip_tags($akreditasi[0]),
            'status' => strip_tags($data[1][36]),
            'jenjang' => strip_tags($data[1][46])
        );
        return ($data['slug'] !== 'silahkankoordinasidengandinassetempat' ? json_encode($data) : json_encode(['status'=>'error']));
    }
}
<?php
if(!function_exists('get_user_data')) {
	function get_user_data($id = false) {
		$ci =& get_instance();
		if (!$id) $id = $ci->session->userdata('id');
		$data = $ci->aauth->get_user($id);
		return $data;
	}
}

if(!function_exists('get_user_var')) {
	function get_user_var($key, $id = false) {
		$ci =& get_instance();
		if (!$id) $id = $ci->session->userdata('id');
		$data = $ci->aauth->get_user_var($key, $id);
		return $data;
	}
}

if(!function_exists('jenjang_sekolah')) {
	function jenjang_sekolah($id = false) {
		$ci =& get_instance();
		$sekolah = _sekolah()->id;
		if ($id) {
			$sekolah = $id;
		}
		$data = $ci->db->get_where('sekolah', ['id'=>$sekolah])->row()->jenjang;
		return $data;
	}
}

if(!function_exists('_sesi')) {
	function _sesi($result) {
		$ci =& get_instance();
		return $ci->session->userdata($result);
	}
}

if(!function_exists('_sekolah')) {
	function _sekolah() {
		$ci =& get_instance();
		$ci->db->where('user_id', $ci->session->userdata('id'));
		$query = $ci->db->get('sekolah');
	    return $query->row();
	}
}

if(!function_exists('_kelas')) {
	function _kelas($where) {
		$ci =& get_instance();
		$ci->db->where(['sekolah_id'=>_sekolah()->id]);
		$ci->db->where($where);
		$ci->db->where('hapus', 0);
	  	$query = $ci->db->get('kelas');
	    return ($query->num_rows() > 0 ? $query->row() : '-');
	}
}

if(!function_exists('_kelas_siswa')) {
	function _kelas_siswa($where) {
		$ci =& get_instance();
		$ci->db->where(['sekolah_id'=>_sekolah()->id]);
		$ci->db->where('tahun', date('Y'));
		$ci->db->where($where);
	  	$query = $ci->db->get('kelas_siswa');
	    return ($query->num_rows() > 0 ? $query->row() : '-');
	}
}

if(!function_exists('_user')) {
	function _user($where) {
		$ci =& get_instance();
		$ci->db->where(['sekolah'=>_sekolah()->id]);
		$ci->db->where($where);
	  	$query = $ci->db->get('aauth_users');
	    return $query->row();
	}
}

if(!function_exists('db_get_all_data')) {
	function db_get_all_data($table_name = null, $where = false, $limit = false) {
		$ci =& get_instance();
		if ($where) {
			$ci->db->where($where);
		}
		if ($limit) {
			$ci->db->limit($limit);
		}
	  	$query = $ci->db->get($table_name);
	    return $query->result();
	}
}

if(!function_exists('db_get_data')) {
	function db_get_data($table_name = null, $where) {
		$ci =& get_instance();
		$ci->db->where($where);
	  	$query = $ci->db->get($table_name);
	    return $query->row();
	}
}

if(!function_exists('db_insert_data')) {
	function db_insert_data($table_name = null, $data) {
		$ci =& get_instance();
		$ci->db->set($data);
	  	$ci->db->insert($table_name);
	    return $ci->db->insert_id();
	}
}

if(!function_exists('db_update_data')) {
	function db_update_data($table_name = null, $data, $where) {
		$ci =& get_instance();
		$ci->db->set($data);
        $ci->db->where($where);
	  	$query = $ci->db->update($table_name);
	    return $query;
	}
}

if(!function_exists('save_avatar')) {
	function save_avatar($name) {
		$url = 'https://ui-avatars.com/api/?size=256&format=svg&background=3b3f5c&color=fff&name=';
		$filename = $name.'.svg';
		$ch = curl_init($url.$name);
		$fp = fopen('./assets/img/'.$filename, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		db_update_data('aauth_users', ['avatar'=>$filename], ['username'=>$name]);
		return true;
	}
}

if(!function_exists('get_user_level')) {
	function get_user_level($id = false) {
		$ci =& get_instance();
		if (!$id) $id = $ci->session->userdata('id');
		$level = $ci->aauth->get_user_first_group($id);
		return $level; //name
	}
}

if(!function_exists('get_sesi_sekolah')) {
	function get_sesi_sekolah($id = false) {
		$ci =& get_instance();
		if (!$id) $id = $ci->session->userdata('id');
		$sekolah = $ci->aauth->get_user_var('sekolah', $id);
		return $sekolah; //id
	}
}

if(!function_exists('get_sesi_kelas')) {
	function get_sesi_kelas($id = false) {
		$ci =& get_instance();
		if (!$id) $id = $ci->session->userdata('id');
		$kelas = $ci->aauth->get_user_var('kelas', $id);
		return $kelas; //id
	}
}

if(!function_exists('verify_user')) {
	function verify_user() {
		$ci =& get_instance();
		$id = $ci->session->userdata('id');
		$user = $ci->aauth->get_user($id);
		$sekolah = $ci->db->get_where('sekolah', ['id'=>$user->sekolah]);
		return ($sekolah->num_rows() > 0 ? true : false);
	}
}

if(!function_exists('verify_table')) {
	function verify_table($table_name, $id_table) {
		$ci =& get_instance();
		$id = $ci->session->userdata('id');
		$user = $ci->aauth->get_user($id);
		$table = $ci->db->get_where($table_name, ['id'=>$id_table, 'sekolah_id'=>$user->sekolah]);
		return ($table->num_rows() > 0 ? true : false);
	}
}

if(!function_exists('verify_siswa')) {
	function verify_siswa($id_user) {
		$ci =& get_instance();
		$id = $ci->session->userdata('id');
		$user = $ci->aauth->get_user($id);
		$data = $ci->db->get_where('aauth_users', ['id'=>$id_user, 'sekolah'=>$user->sekolah]);
		return ($data->num_rows() > 0 ? true : false);
	}
}

function base69encode($data) {
    $outstring = '';
    $l = strlen($data);
    for ($i = 0; $i < $l; $i += 8) {
        $chunk = substr($data, $i, 8);
        $outlen = ceil((strlen($chunk) * 8)/6); //8bit/char in, 6bits/char out, round up
        $x = bin2hex($chunk);  //gmp won't convert from binary, so go via hex
        $w = gmp_strval(gmp_init(ltrim($x, '0'), 16), 62); //gmp doesn't like leading 0s
        $pad = str_pad($w, $outlen, '0', STR_PAD_LEFT);
        $outstring .= $pad;
    }
    return $outstring;
}

function base69decode($data) {
    $outstring = '';
    $l = strlen($data);
    for ($i = 0; $i < $l; $i += 11) {
        $chunk = substr($data, $i, 11);
        $outlen = floor((strlen($chunk) * 6)/8); //6bit/char in, 8bits/char out, round down
        $y = gmp_strval(gmp_init(ltrim($chunk, '0'), 62), 16); //gmp doesn't like leading 0s
        $pad = str_pad($y, $outlen * 2, '0', STR_PAD_LEFT); //double output length as as we're going via hex (4bits/char)
        $outstring .= pack('H*', $pad); //same as hex2bin
    }
    return $outstring;
}

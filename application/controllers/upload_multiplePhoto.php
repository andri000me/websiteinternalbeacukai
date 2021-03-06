<?php
class Upload extends CI_Controller
{

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','file'));
	}

	function index(){
		$this->load->view('upload_view');
	}

	function proses_upload(){

        $config['upload_path']   = FCPATH.'/upload-foto/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
        $this->load->library('humas_rt',$config);

        if($this->upload->do_upload('userfile')){
        	$token=$this->input->post('token_foto');
        	$nama=$this->upload->data('file_name');
        	$this->db->insert('foto',array('file_name'=>$nama,'token'=>$token));
        }

	}

	//Untuk menghapus foto
	function remove_foto(){

		//Ambil token foto
		$token=$this->input->post('token');
		
		$foto=$this->db->get_where('foto',array('token'=>$token));

		if($foto->num_rows()>0){
			$hasil=$foto->row();
			$nama_foto=$hasil->nama_foto;
			if(file_exists($file=FCPATH.'/upload-foto/'.$nama_foto)){
				unlink($file);
			}
			$this->db->delete('foto',array('token'=>$token));

		}

		echo "{}";
	}

}
<?php

namespace App\Controllers;

use App\Models\UserServersideModel;
use Config\Services;

class UserController extends BaseController
{
	public function index()
	{
		$data['title'] = 'User - CRUD AJAX';

		return view('user_view/v_index', $data);
	}

	public function getAllUser()
	{
		if ($this->request->isAJAX()) {
			$view = [
				'data' => view('data_view/v_datauser'),
			];

			echo json_encode($view);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function userServerside()
	{
		if ($this->request->isAJAX()) {
			$request = Services::request();
			$UserServersideModel = new UserServersideModel($request);

			if ($request->getMethod(true) == 'POST') {
				$lists = $UserServersideModel->get_datatables();
				$data = [];
				$no = $request->getPost("start");
				foreach ($lists as $list) {
					$no++;
					$row = [];

					$tomboledit = "<button type=\"button\" class=\"btn btn-primary btn-sm my-1\" onclick=\"editData(" . $list['id_user'] . ")\"><i class=\"fa fa-edit\"></i> </button>";

					$tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm my-1\" onclick=\"deleteData(" . $list['id_user'] . ")\"><i class=\"fa fa-trash-alt\"></i> </button>";

					$row[] = "<input type=\"checkbox\" class=\"checkbox_user\" value=\"" . $list['id_user'] . "\">";
					$row[] = $no;
					$row[] = $list['nama_user'];
					$row[] = $list['tgllahir_user'];
					$row[] = $list['nama_kewarganegaraan'];
					$row[] = $tomboledit . " " . $tombolhapus;

					$data[] = $row;
				}
				$output = [
					"draw" => $request->getPost('draw'),
					"recordsTotal" => $UserServersideModel->count_all(),
					"recordsFiltered" => $UserServersideModel->count_filtered(),
					"data" => $data
				];
				echo json_encode($output);
			}
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function addUser()
	{
		if ($this->request->isAJAX()) {
			$data['kewarganegaraan'] = $this->KewarganegaraanModel->select('id_kewarganegaraan, nama_kewarganegaraan')->findAll();

			$view = [
				'data' => view('data_view/v_tambahdata', $data),
			];

			echo json_encode($view);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function saveAddUser()
	{
		if ($this->request->isAJAX()) {
			$jumlah_data = count($this->request->getVar('nama_user'));

			$validation = \Config\Services::validation();

			// Perulangan untuk validasi
			for ($i = 0; $i < $jumlah_data; $i++) {
				$valid = $this->validate([
					"nama_user.$i" => [
						"label" => "Nama user",
						"rules" => "required|alpha_space|max_length[100]",
						"errors" => [
							"required" => "{field} tidak boleh kosong",
							"alpha_space" => "{field} hanya boleh mengandung huruf dan spasi",
							"max_length" => "{field} terlalu panjang (max:100)",
						]
					],
					"tgllahir_user.$i" => [
						"label" => "Tanggal lahir",
						"rules" => "required|valid_date",
						"errors" => [
							"required" => "{field} tidak boleh kosong",
							"valid_date" => "{field} tidak valid",
						]
					],
				]);

				// Membuat pesan error dalam bentuk array
				$error[$i] = [
					'nama_user' => $validation->getError("nama_user.$i"),
					'tgllahir_user' => $validation->getError("tgllahir_user.$i"),
				];

				// Validasi khusus untuk kewarganegaraan (jika user melakukan inspect element)
				if ($this->KewarganegaraanModel->select('id_kewarganegaraan')->find($this->request->getVar('kewarganegaraan')[$i]) == null) {
					$error[$i]['kewarganegaraan'] = 'Kewarganegaraan tersebut tidak ada';
				}
			}

			// Jika terdapat kesalahan
			if (!$valid) {
				$error["jumlah_data"] = $jumlah_data;
				$view = $error;
			} else {
				// Mengambil data dari request
				$nama_user = $this->request->getVar('nama_user');
				$tgllahir_user = $this->request->getVar('tgllahir_user');
				$kewarganegaraan = $this->request->getVar('kewarganegaraan');

				// Perulangan untuk menyiapkan array yang akan diinsert
				for ($i = 0; $i < $jumlah_data; $i++) {
					$data[$i] = [
						'nama_user' => htmlspecialchars($nama_user[$i]),
						'tgllahir_user' => htmlspecialchars($tgllahir_user[$i]),
						'id_kewarganegaraan-user' => htmlspecialchars($kewarganegaraan[$i]),
					];
				}

				// Insert banyak ke database
				$this->UserModel->insertBatch($data);

				// Mengembalikan pesan berhasil
				$view = [
					'success' => "$jumlah_data data tersebut berhasil ditambahkan",
				];
			}

			echo json_encode($view);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function deleteUser()
	{
		if ($this->request->isAJAX()) {
			$id_user = $this->request->getVar('id_user');
			$jmldata = count($id_user);
			$jmlditemukan = count($this->UserModel->select('id_user')->find($id_user));

			$this->UserModel->delete($id_user);

			// Jika data yang dihapus hanya 1
			if ($jmldata == 1) {
				// Jika jumlah data yang ditemukan sama dengan jumlah data yang ingin dihapus
				if ($jmlditemukan == $jmldata) {
					$view = [
						'success' => "Data tersebut berhasil dihapus",
					];
				} else {
					$view = [
						'error' => "Data tersebut tidak ditemukan",
					];
				}
			} else {
				if ($jmlditemukan == null) {
					$view = [
						'error' => "$jmldata data tersebut tidak ditemukan",
					];
				} else if ($jmlditemukan == $jmldata) {
					$view = [
						'success' => "$jmldata data tersebut berhasil dihapus",
					];
				} else {
					$view = [
						'warning' => "$jmlditemukan data berhasil dihapus, tapi " . ($jmldata - $jmlditemukan) . ' data lainnya tidak ditemukan',
					];
				}
			}

			echo json_encode($view);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function editUser()
	{
		if ($this->request->isAJAX()) {
			$data['user'] = $this->UserModel->select('id_user, nama_user, tgllahir_user, id_kewarganegaraan-user')->find($this->request->getVar('id_user'));
			$data['kewarganegaraan'] = $this->KewarganegaraanModel->select('id_kewarganegaraan, nama_kewarganegaraan')->findAll();

			// Jika data yang akan dihapus tidak ditemukan
			if ($data['user'] == null) {
				$view = [
					'error' => "Data tersebut tidak ditemukan",
				];
			} else {
				$view = [
					'data' => view('data_view/v_editdata', $data),
				];
			}

			echo json_encode($view);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function saveEditUser()
	{
		if ($this->request->isAJAX()) {
			$jumlah_data = count($this->request->getVar('id_user'));

			$validation = \Config\Services::validation();

			// Perulangan untuk validasi
			for ($i = 0; $i < $jumlah_data; $i++) {
				$valid = $this->validate([
					"nama_user.$i" => [
						"label" => "Nama user",
						"rules" => "required|max_length[100]",
						"errors" => [
							"required" => "{field} tidak boleh kosong",
							"max_length" => "{field} terlalu panjang (max:100)",
						]
					],
					"tgllahir_user.$i" => [
						"label" => "Tanggal lahir",
						"rules" => "required|valid_date",
						"errors" => [
							"required" => "{field} tidak boleh kosong",
							"valid_date" => "{field} tidak valid",
						]
					],
				]);

				// Membuat pesan error dalam bentuk array
				$error[$i] = [
					'nama_user' => $validation->getError("nama_user.$i"),
					'tgllahir_user' => $validation->getError("tgllahir_user.$i"),
				];

				// Validasi khusus untuk kewarganegaraan (jika user melakukan inspect element)
				if ($this->KewarganegaraanModel->select('id_kewarganegaraan')->find($this->request->getVar('kewarganegaraan')[$i]) == null) {
					$error[$i]['kewarganegaraan'] = 'Kewarganegaraan tersebut tidak ada';
				}
			}

			// Jika terdapat kesalahan
			if (!$valid) {
				$error["jumlah_data"] = $jumlah_data;
				$view = $error;
			} else {
				// Mengambil data dari request
				$id_user = $this->request->getVar('id_user');
				$nama_user = $this->request->getVar('nama_user');
				$tgllahir_user = $this->request->getVar('tgllahir_user');
				$kewarganegaraan = $this->request->getVar('kewarganegaraan');

				// Perulangan untuk menyiapkan array yang akan diupdate
				for ($i = 0; $i < $jumlah_data; $i++) {
					$data[$i] = [
						'id_user' => $id_user[$i],
						'nama_user' => htmlspecialchars($nama_user[$i]),
						'tgllahir_user' => htmlspecialchars($tgllahir_user[$i]),
						'id_kewarganegaraan-user' => htmlspecialchars($kewarganegaraan[$i]),
					];
				}

				// Update banyak ke database
				$this->UserModel->updateBatch($data, 'id_user');

				// Mengembalikan pesan berhasil
				$view = [
					'success' => "$jumlah_data data tersebut berhasil diubah",
				];
			}

			echo json_encode($view);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}
}

<?php

namespace application\models;

use application\core\Model;
use Aws\S3\Exception\S3Exception;


class Bucket extends Model {

	public function imgValidate($post,$type){
		if ($_FILES['img']['error'] and $type =='add') {
			$this->error = 'Выберите файл';
			return false;
		} elseif ($_FILES['img']['size'] > 20000000) { // 20 мегабайт
			$this->error = 'Фото большое';
			return false;
		}
		return true;
	}

	public function imgExist($route){
		require 'application/config/autoload.php';
		if ($route['action'] == 'settings') {
			$object['Key'] = 'images/users/'.$route['id'].'/1.jpg';
		}elseif($route['action'] == 'edit') {
			$object['Key'] = 'images/offers/'.$route['id'].'/1.jpg';
		}

		return $s3->doesObjectExist($config['s3']['bucket'], $object['Key']);
	}

	public function saveImg($path, $id, $type) {
		require 'application/config/autoload.php';
		if (!empty($_FILES['img'])) {

			$file = $_FILES['img']; // Getting Img
			// File Details
			$name = '1.jpg'; // Название изначальное
			$tmp_name = $file['tmp_name']; // Темп файла

			$extension = explode('.', $name); // Расширение файла
			$extension = strtolower(end($extension));

			// Temp Details
			$key = $id; // Сгенерированый уникальная строчка
			$tmp_file_name = "{$key}.{$extension}"; // Даём новое имя
			$tmp_file_path = "public/data/{$tmp_file_name}";


			// Move the file
			move_uploaded_file($tmp_name, $tmp_file_path);
			$fopen = fopen($tmp_file_path, 'rb');

			try {
				$result = $s3->putObject([
					'Bucket' => $config['s3']['bucket'],
					'Key' => "images/{$type}/{$key}/{$name}",
					'Body' => $fopen,
					'ACL' => 'public-read',
				]);

				// echo $result->get('ObjectURL');
				// Delete File
				fclose($fopen);
				unlink($tmp_file_path);

			} catch(Aws\S3\Exception\S3Exception $e) {
				echo 'Ошибка загрузки';
				echo $e->getMessage();
			}
		}
		
	}


	public function deleteImg($id, $type){
		require 'application/config/autoload.php';
		$key = $id;
		$name = '1.jpg';
		$result = $s3->deleteObject([
		    'Bucket' => $config['s3']['bucket'],
		    'Key' => "images/{$type}/{$key}/{$name}",
		]);
	}

	public function bulkRemovalOffers($arr){
		require 'application/config/autoload.php';
		$str = '';
		for($i = 0;$i <= count($arr)-1; $i++){$str .= ($arr[$i]['id']).',';}
		$str = (substr($str, 0, -1));
		$keys = explode(',',$str);
		$name = '1.jpg';
			$result = $s3->deleteObjects([
			    'Bucket' => $config['s3']['bucket'],
				'Delete' => [
					'Objects' => array_map(function ($key) {
						return [
							'Key' => "images/offers/{$key}/1.jpg",
						];
					}, $keys)
				],
			]);
	}

	public function bulkRemovalActions($arr){
		require 'application/config/autoload.php';
		$str = '';
		for($i = 0;$i <= count($arr)-1; $i++){$str .= ($arr[$i]['id']).',';}
		$str = (substr($str, 0, -1));
		$keys = explode(',',$str);
		$name = '1.jpg';
			$result = $s3->deleteObjects([
			    'Bucket' => $config['s3']['bucket'],
				'Delete' => [
					'Objects' => array_map(function ($key) {
						return [
							'Key' => "images/actions/{$key}/1.jpg",
						];
					}, $keys)
				],
			]);
	}


}
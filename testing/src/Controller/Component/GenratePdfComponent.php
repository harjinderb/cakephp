<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * GenratePdf  component
 *
 */
class GenratePdfComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [

	];

	public function genratepdf($html, $path, $basePath) {
		$mpdf = new \Mpdf\Mpdf();
		if (is_dir($basePath)) {
			@chmod($basePath, 0777);
			unlink($path);
			rmdir($basePath);
		}
		if (!file_exists($path)) {
			mkdir($basePath, 0777, true);
		}
		//pr($html);die;
		$mpdf->WriteHTML($html, $path);
		@chmod($path, 0777);
		$mpdf->Output($path, 'F');
		return $path;

	}

}
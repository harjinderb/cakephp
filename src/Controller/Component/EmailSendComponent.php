<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;

/**
 * Send Email component
 */
class EmailSendComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [

	];

	public function emailSend($from = null, $title = null, $to = null, $subject = null, $message = null, $headers = null) {
		$email = new Email('default');
		$email->setFrom([$from => $title]);
		$email->setTo($to);
		$email->setSubject($subject);
		$email->setEmailFormat('html');
		//->send($message);
		if ($email->send($message)) {
			return true;
		} else {
			return false;
		}
	}
	public function emailSendwithattach($from = null, $title = null, $to = null, $subject = null, $attachment = null, $message = null, $headers = null) {
		$email = new Email('default');
		$email->setFrom([$from => $title]);
		$email->setTo($to);
		$email->setSubject($subject);
		$email->setEmailFormat('html');
		$email->setAttachments($attachment); //Path of attachment file;

		if ($email->send($message)) {
			return true;
		} else {
			return false;
		}
	}

}

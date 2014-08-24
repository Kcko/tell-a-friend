<?php
namespace CMS;

use Nette,
	Nette\Mail\Message,
	Nette\Mail\SendmailMailer;

class TellAFriend extends Nette\Application\UI\Control {
	
	public $send = FALSE;

	public function render()
	{	
		$template = $this->template;
		$template->setFile(__DIR__ . '/tellafriend.latte');
		$template->send = $this->send;
		$template->render();	
	}

	public function createComponentSendMailForm()
	{
		$this->redrawControl('tellafriend');

		$form = new Nette\Application\UI\Form;
		$form->setAction('?');
		
		$form
			->addText('mailto', 'Mail to')
			->setAttribute('placeholder', 'od koho (e-mail)')
			->setRequired('Zadejte prosím platný e-mail')
			->setType('email')
			->addRule($form::EMAIL, 'Zadejte prosím platný e-mail');

		$form
			->addText('mailfrom', 'Mail from')
			->setAttribute('placeholder', 'komu (e-mail)')
			->setRequired('Zadejte prosím platný e-mail')
 	      	->setType('email')
            ->addRule($form::EMAIL, 'Zadejte prosím platný e-mail');

		$form->addSubmit('send', 'odeslat e-mail');
        $form->onSuccess[] = $this->sendEmail;
		return $form;
	}

	public function sendEmail($form)
    {
        $form = $form->getForm();
        $values = $form->getValues();
        
        $template = new Nette\Templating\FileTemplate(__DIR__ . '/message.latte');
        $template->registerFilter(new Nette\Latte\Engine);
        $template->registerHelperLoader('Nette\Templating\Helpers::loader');
        $template->mailfrom = $values->mailfrom;

        $mail = new Message;
        $mail->setFrom($values->mailfrom)
        ->addTo($values->mailto)
        ->setSubject('Upozornění na stránky www.automarkyzy.cz')
        ->setHtmlBody($template);

        $mailer = new SendmailMailer;
        $mailer->send($mail);

        $this->redrawControl('tellafriend');
	    $this->send = TRUE;
    }

}
<?php

namespace App\Controller;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    public function contactSend()
    {
        $contact = [];
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $contact = array_map('trim', $_POST);
            $errors = $this->infoValidate($contact);

            if (empty($errors)) {
                $transport = Transport::fromDsn(MAILER_DSN);
                $mailer = new Mailer($transport);
                $email = (new Email())
                    ->from($contact['email'])
                    ->to(MAIL_TO)
                    ->subject('Message de SNAPSHOT')
                    ->html($this->twig->render('Contact/email.html.twig', ['contact' => $contact]));

                $mailer->send($email);
                header('Location:/contact/thanks/');
            }
        }

        return $this->twig->render('Contact/contact.html.twig', [
            'info' => $contact,
            'errors' => $errors]);
    }
    public function thanks()
    {
        return $this->twig->render('Contact/thanks.html.twig');
    }

    public function infoValidate(array $info): array
    {
        $inputLength = 100;
        $errors = [];
        if (empty($info['firstname'])) {
            $errors[] = 'Le champ prénom est obligatoire';
        }
        if (strlen($info['firstname']) > $inputLength) {
            $errors[] = 'Le champ prénom doit contenir moins de ' . $inputLength . ' caractères';
        }
        if (empty($info['lastname'])) {
            $errors[] = 'Le champ nom est obligatoire';
        }
        if (strlen($info['lastname']) > $inputLength) {
            $errors[] = 'Le champ nom doit contenir moins de ' . $inputLength . ' caractères';
        }
        if (empty($info['email'])) {
            $errors[] = 'Le champ email est obligatoire';
        }
        if (strlen($info['email']) > $inputLength) {
            $errors[] = 'Le champ email doit contenir moins de ' . $inputLength . ' caractères';
        }
        return $errors ?? [];
    }
}
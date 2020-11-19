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
            $errors = $this->contactValidate($contact);

            if (empty($errors)) {
                $transport = Transport::fromDsn(MAILER_DSN);
                $mailer = new Mailer($transport);
                $email = (new Email())
                    ->from($contact['email'])
                    ->to(MAIL_TO)
                    ->subject('Message from SNAPSHOT')
                    ->html($this->twig->render('Contact/email.html.twig', ['contact' => $contact]));

                $mailer->send($email);
                header('Location:/contact/thanks/');
            }
        }

        return $this->twig->render('Contact/contact.html.twig', [
            'contact' => $contact,
            'errors' => $errors]);
    }
    public function thanks()
    {
        return $this->twig->render('Contact/thanks.html.twig');
    }

    public function contactValidate(array $contact): array
    {
        $inputLength = 100;
        $errors = [];
        if (empty($contact['firstname'])) {
            $errors[] = 'The firstname field is required';
        }
        if (strlen($contact['firstname']) > $inputLength) {
            $errors[] = 'The firstname field must contain less than' . $inputLength . ' characters';
        }
        if (empty($contact['lastname'])) {
            $errors[] = 'The lastname field is required';
        }
        if (strlen($contact['lastname']) > $inputLength) {
            $errors[] = 'The lastname field must contain less than' . $inputLength . ' characters';
        }
        if (empty($contact['email'])) {
            $errors[] = 'The email field is required';
        }
        if (strlen($contact['email']) > $inputLength) {
            $errors[] = 'The email field must contain less than' . $inputLength . ' characters';
        }
        return $errors ?? [];
    }
}

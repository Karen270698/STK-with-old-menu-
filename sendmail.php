<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->Charset = 'UTF-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    //От кого письмо
    $mail->setFrom('stknet.ru', 'Клиент');
    //Кому отправить
    $mail->addAddress('karenjeday98@mail.ru');
    //Тема письма
    $mail->Subject = 'Новая заявка!';

    //Рука
    $hand = "Rigth";
    if($_POST['hand'] == "left") {
        $hand = "Left";
    }

    //Тело письма
    $body = '<h1>Новая заявка!</h1>';

    if(trim(!empty($_POST['name']))){
        $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
    }
    if(trim(!empty($_POST['email']))){
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }
    if(trim(!empty($_POST['hand']))){
        $body.='<p><strong>Рука:</strong> '.$hand.'</p>';
    }
    if(trim(!empty($_POST['age']))){
        $body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
    }
    if(trim(!empty($_POST['message']))){
        $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
    }

    //Прикрепить файл
    if (!empty($_FILES['iamge']['tmp_name'])) {
        //путь загрузки файла
        $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
        //грузим файл
        if (copy($_FILES['image']['tmp_name'], $filePath)) {
            $fileAttach = $filePath;
            $body.='<p><strong>Фото в приложении</strong></p>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    //Отправляем
    if (!$mail->send()) {
        $maessage = 'Ошибка';
    } else {
        $maessage = 'Заявка отправлена!';
    }

    $response = ['message' => $maessage];

    header('Content-type: application/json');
    echo json_encode($response);

?>
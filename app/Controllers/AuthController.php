<?php

namespace App\Controllers;
use App\Models\User;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Support\Auth;
use Support\BaseController;
use Support\Request;
use Support\Response;
use Support\Session;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class AuthController extends BaseController
{
    // Controller logic here
    public function index()
    {
        return view('auth/login');
    }

    public function onLogin(Request $request)
    {
        $credentials = [
            'identifier' => $request->username,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            return redirect('/home');
        }
        // $user = User::query()
        //         ->where('username','=',$request->username)
        //         ->first();
        //         // print_r($user);
        // if($user && password_verify($request->password,$user->password)){
        //     Session::set('user',[
        //         'username' => $user->username
        //     ]);
        //     return redirect('/home');
        // }
        return view('auth/login');
    }

    public function logout(Request $request)
    {
        Session::destroy();
        return redirect('/login');
    }

    public function sendEmail()
    {
        $mail = new PHPMailer();
        try {
            // Server Settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ISE00007@stanley-electric.com';
            $mail->Password = 'Stanley@01';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            //Recipients
            $mail->setFrom('ISE00007@stanley-electric.com', 'Test MAILER');
            $mail->addAddress('fadli_azka_prayogi@stanley-electric.com', 'Fadli'); //Add a recipient
            $mail->addAddress('fadli_azka_prayogi@stanley-electric.com'); //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Test PHPMAILER';
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
            View::redirectTo('/home');
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function getClientInfo() 
    {
        // Mendapatkan IP address
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
    
        // Mendapatkan hostname berdasarkan IP
        $hostname = gethostbyaddr($ip);
    
        // return [
        //     'ip' => $ip,
        //     'hostname' => $hostname
        // ];
        return view('test',['ip'=>$ip,'hostname'=>$hostname]);
    }
    
    // // Gunakan fungsi ini
    // $clientInfo = getClientInfo();
    // echo "IP: " . $clientInfo['ip'] . "<br>";
    // echo "Hostname: " . $clientInfo['hostname'];
    
}

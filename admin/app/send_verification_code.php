<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';
require_once '../../includes/mailer.php';


function generateVerificationCode(): string
{
    $verification_code = md5(rand(pow(10, 10 - 1), pow(10, 10) - 1));
    return  $verification_code = substr(strtoupper($verification_code), 0, 6);
}

function sendEmailVerification(string $code, string $name, string $email)
{
    $mail_body = file_get_contents('../emails/verification.html');
    $mail_body = str_replace('{code}', $code, $mail_body);
    $recipient['name'] = $name;
    $recipient['email'] = $email;
    sendMail($recipient, 'Verify Account', $mail_body, '');

    Session::insertSession('verification_sent_at', date('Y-m-d H:i:s'));
}

$admin = Session::getUser($pdo);

if ($admin['email_verified_at'] == null) {
    if ($admin['verification_code'] == null) {
        $verification_code = generateVerificationCode();
        $query = $pdo->prepare('UPDATE admins SET verification_code = ?, verification_code_created_at = CURRENT_TIMESTAMP() WHERE id = ?');
        $query->execute([$verification_code, $admin['id']]);

        sendEmailVerification($verification_code,$admin['firstname'], $admin['email']);
    } else {
        $query = $pdo->prepare("SELECT CURRENT_TIMESTAMP()");
        $query->execute();
        $currentTime = $query->fetch()[0];

        $dateInterval = date_diff(
            new DateTime($admin['verification_code_created_at'], new DateTimeZone('Singapore')),
            new DateTime($currentTime, new DateTimeZone('Singapore')),
            true
        );

        if ($dateInterval->i >= 5) { //if already expired
            $verification_code = generateVerificationCode();
            while ($verification_code == $admin['verification_code']) {
                $verification_code = generateVerificationCode();
            }
            $query = $pdo->prepare('UPDATE admins SET verification_code = ?, verification_code_created_at = CURRENT_TIMESTAMP() WHERE id = ?');
            $query->execute([$verification_code, $admin['id']]);
            sendEmailVerification($verification_code,$admin['firstname'], $admin['email']);
        } else { //if not yet expired
            if (Session::hasSession('verification_sent_at')) {
                $verification_sent_at = Session::getSession('verification_sent_at');
                $dateInterval = date_diff(
                    new DateTime($verification_sent_at, new DateTimeZone('singapore')),
                    new DateTime('now', new DateTimeZone('singapore'))
                );

                // if already been a minute after being sent
                if ($dateInterval->i >= 1) {
                    // send code again
                    sendEmailVerification($admin['verification_code'], $admin['firstname'], $admin['email']);
                } else {
                    echo json_encode([
                        'message' => 'Please wait for one minute before requesting verification code again!',
                        'success' => false
                    ]);
                    exit;
                }
            } else {
                sendEmailVerification($admin['verification_code'], $admin['firstname'], $admin['email']);
            }
        }
    }
    echo json_encode([
        'message' => 'We successfully sent your verification code!',
        'success' => true
    ]);
}

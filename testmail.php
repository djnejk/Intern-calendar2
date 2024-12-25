<?php
$apiKey = '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'; // Nahraďte svým API klíčem ze Sendinblue
$senderEmail = 'djnejk@djdevs.eu';
$senderName = 'Your Name';
$recipientEmail = 'djnejk@djdevs.eu';
$recipientName = 'Recipient Name';
$subject = 'Here is the subject';
$htmlContent = '<p>This is the <b>HTML</b> message body.</p>';
$textContent = 'This is the plain text message body.';

$data = [
  'sender' => [
      'name' => $senderName,
      'email' => $senderEmail,
  ],
  'to' => [
      [
          'email' => $recipientEmail,
          'name' => $recipientName,
      ],
  ],
  'subject' => $subject,
  'htmlContent' => $htmlContent,
  'textContent' => $textContent,
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$headers = [];
$headers[] = 'Content-Type: application/json';
$headers[] = 'api-key: ' . $apiKey;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
} else {
  echo 'Email sent successfully!';
}

curl_close($ch);
?>
<?php

require '../Include/Config.php';
//require '../Include/Functions.php';

// This file is generated by Composer
require_once dirname(__FILE__) . '/../vendor/autoload.php';

use EcclesiaCRM\dto\SystemConfig;
use EcclesiaCRM\dto\ChurchMetaData;
use EcclesiaCRM\SessionUser;

?>
<html>
<header>
    <title>SMTP Test</title>
</header>
<body>
<?php
if (SessionUser::getUser()->isAdmin()) {
    $mail = new \PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Timeout = intval(SystemConfig::getValue("iSMTPTimeout"));
    $mail->Host = SystemConfig::getValue("sSMTPHost");
    if (SystemConfig::getBooleanValue("bSMTPAuth")) {
        $mail->SMTPAuth = true;
        echo "SMTP Auth Used </br>";
        $mail->Username = SystemConfig::getValue("sSMTPUser");
        $mail->Password = SystemConfig::getValue("sSMTPPass");
    }

    $mail->SMTPDebug = 2;
    $mail->Subject = "Test SMTP Email";
    $mail->setFrom(ChurchMetaData::getChurchEmail());
    $mail->addAddress(ChurchMetaData::getChurchEmail());
    $mail->Body = "test email";
    $mail->send()
    ?>

    <pre>
    <?= $mail->ErrorInfo; ?>
</pre>
    <?php
} else {
        echo "for use by admins only";
    }
?>
</body>
</html>
<?php 
// pour le debug on se met au bon endroit : http://192.168.151.205/mysql/upgrade/5.4.2-upgrade.php
// et il faut décommenter
/*define("webdav", "1");
require '../../Include/Config.php';*/

  use Propel\Runtime\Propel;
  use EcclesiaCRM\Utils\LoggerUtils;
  use EcclesiaCRM\dto\SystemURLs;
  use EcclesiaCRM\Utils\MiscUtils;

  $logger = LoggerUtils::getAppLogger();
  
  $logger->info("Start to delete : all unusefull files");
  
  MiscUtils::removeDirectory(SystemURLs::getDocumentRoot()."/email/");

  unlink(SystemURLs::getDocumentRoot()."/VolunteerOpportunityEditor.php");
  unlink(SystemURLs::getDocumentRoot()."/MenuLinksList.php");
  unlink(SystemURLs::getDocumentRoot()."/PastoralCareList.php");
  unlink(SystemURLs::getDocumentRoot()."/Calendar.php");
  unlink(SystemURLs::getDocumentRoot()."/FundList.php");
  
  $logger->info("End of Reset :  all unusefull files");
?>

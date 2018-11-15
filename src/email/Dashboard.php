<?php
/*******************************************************************************
 *
 *  filename    : Dashboard.php
 *  last change : 2014-11-29
 *  website     : http://www.ecclesiacrm.com
 *  copyright   : Copyright 2014
 *
 ******************************************************************************/

require '../Include/Config.php';
require '../Include/Functions.php';

use EcclesiaCRM\Service\MailChimpService;
use EcclesiaCRM\dto\SystemURLs;

if (!($_SESSION['user']->isMailChimpEnabled())) {
    Redirect('Menu.php');
    exit;
}

$mailchimp = new MailChimpService();

//Set the page title
$sPageTitle = gettext('eMail Dashboard');

require '../Include/Header.php';

//print_r ($_SESSION['MailChimpLists']);
?>
<div class="row">
  <div class="col-lg-12">
    <div class="box">
      <div class="box-header   with-border">
        <h3 class="box-title"><?= gettext('Email Export') ?></h3>
      </div>
      <div class="box-body">
        <p>
          <a href="" class="btn btn-app" id="CreateList">
            <i class="fa fa-list-alt"></i><?= gettext("Create a Mailing list") ?>
          </a>
          <a class="btn btn-app" href="MemberEmailExport.php">
            <i class="fa fa fa-table"></i> <?= gettext('Generate CSV') ?>
          </a>
          <a href="<?= SystemURLs::getRootPath() ?>/email/DuplicateEmails.php" class="btn btn-app">
            <i class="fa fa-exclamation-triangle"></i> <?= gettext("Find Duplicate Emails") ?>
          </a>
          <a href="<?= SystemURLs::getRootPath() ?>/email/NotInMailChimpEmails.php" class="btn btn-app">
            <i class="fa fa-bell-slash"></i><?= gettext("Families Without NewsLetters") ?>
          </a>
        </p>
        <?= gettext('You can import the generated CSV file to external email system.') ?>
            <?= _("For MailChimp see") ?> <a href="http://kb.mailchimp.com/lists/growth/import-subscribers-to-a-list"
                                   target="_blank"><?= gettext('import subscribers to a list.') ?></a>
      </div>
    </div>
  </div>
</div>

<?php if ($mailchimp->isActive()) {
    $mcLists = $mailchimp->getLists(); ?>
  <div class="row">
    <?php 
      foreach ($mcLists as $list) {
    ?>
      <div class="col-lg-12">
        <div class="box">
          <div class="box-header   with-border">
            <h3 class="box-title"><?= gettext('MailChimp List') ?>: <?= $list['name'] ?></h3> <a href="<?= SystemURLs::getRootPath() ?>/email/ManageList.php?list_id=<?= $list['id'] ?>"><i class="fa pull-right fa-gear" style="font-size: 1.2em"></i></a>
          </div>
          <div class="box-body">
             <table width='300px'>
                <tr><td><b><?= gettext('Members:') ?></b> </td><td><?= $list['stats']['member_count'] ?></td></tr>
                <tr><td><b><?= gettext('Campaigns:') ?></b> </td><td><?= $list['stats']['campaign_count'] ?></td></tr>
                <tr><td><b><?= gettext('Unsubscribed count:') ?></b> </td><td><?= $list['stats']['unsubscribe_count'] ?></td></tr>
                <tr><td><b><?= gettext('Unsubscribed count since last send:') ?></b> </td><td><?= $list['stats']['unsubscribe_count_since_send'] ?></td></tr>
                <tr><td><b><?= gettext('Cleaned count:') ?></b> </td><td><?= $list['stats']['cleaned_count'] ?></td></tr>
                <tr><td><b><?= gettext('Cleaned count since last send:') ?></b> </td><td><?= $list['stats']['cleaned_count_since_send']?> </td></tr>
              </table>
          </div>
        </div>
      </div>
    <?php
      } 
    ?>
    <br>
  </div>
<?php
} else {
?>
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-body">
        <div class="alert alert-danger alert-dismissible">
          <h4><i class="fa fa-ban"></i> MailChimp <?= gettext('is not configured') ?></h4>
          <?= gettext('Please update the') ?> MailChimp <?= gettext('API key in Setting->') ?><a href="../SystemSettings.php"><?= gettext('Edit General Settings') ?></a>,
          <?= gettext('then update') ?> sMailChimpApiKey. <?= gettext('For more info see our ') ?><a href="<?= SystemURLs::getSupportURL() ?>"> MailChimp <?= gettext('support docs.') ?></a>
        </div>
      </div>
    </div>
  </div>


<?php
}
require '../Include/Footer.php';
?>

<script nonce="<?= SystemURLs::getCSPNonce() ?>">  
  $(document).on("click","#CreateList", function(){
    window.CRM.APIRequest({
      method: 'POST',
      path: 'mailchimp/createlist'
      //data: JSON.stringify({"pastoralCareTypeId": pastoralCareTypeId})
    }).done(function(data) {
       location.reload();
    });
  });  



</script>

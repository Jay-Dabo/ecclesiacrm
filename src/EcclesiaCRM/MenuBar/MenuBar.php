<?php
/*******************************************************************************
*
*  filename    : MenuBar.php
*  website     : http://www.ecclesiacrm.com
*  function    : List all Church Events
*
*  This code is under copyright not under MIT Licence
*  copyright   : 2018 Philippe Logel all right reserved not MIT licence
*                This code can't be incoprorated in another software without authorizaion
*  Updated     : 2019/02/5
*
******************************************************************************/

namespace EcclesiaCRM\MenuBar;

use EcclesiaCRM\dto\SystemURLs;
use EcclesiaCRM\dto\SystemConfig;
use EcclesiaCRM\ListOptionQuery;
use EcclesiaCRM\GroupQuery;
use EcclesiaCRM\PropertyQuery;
use EcclesiaCRM\Record2propertyR2pQuery;
use EcclesiaCRM\Map\Record2propertyR2pTableMap;
use EcclesiaCRM\Map\PropertyTableMap;
use EcclesiaCRM\Map\PropertyTypeTableMap;
use EcclesiaCRM\Map\GroupTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use EcclesiaCRM\DepositQuery;
use EcclesiaCRM\MenuLinkQuery;
use EcclesiaCRM\Service\MailChimpService;
use EcclesiaCRM\SessionUser;


class MenuBar {
    private $_title;
    private $_menus  = [];
    private $_maxStr = 25;// maximum numbers of char in the menu items
    
    
    // Simple : Constructor
    public function __construct($title)
    {
      $this->_title = $title;
      $this->createMenuBar();
    }
    
    public function addMenu ($menu)
    {
      array_push($this->_menus, $menu);
    }
    
    private function addGroups()
    {
      // the assigned Groups
      $menu = new Menu (gettext("Groups"),"fa fa-tag","#",true);
      
      $menuItem = new Menu (gettext("List Groups"),"fa fa-circle-o","GroupList.php",SessionUser::getUser()->isAddRecordsEnabled(),$menu);
      
      $listOptions = ListOptionQuery::Create()
                    ->filterById(3)
                    ->orderByOptionSequence()
                    ->find();

      foreach ($listOptions as $listOption) {
          if ($listOption->getOptionId() != 4) {// we avoid the sundaySchool, it's done under
              $groups=GroupQuery::Create()
                  ->filterByType($listOption->getOptionId())
                  ->orderByName()
                  ->find();

              if ($groups->count()>0) {// only if the groups exist : !empty doesn't work !
                 
                  $menuItem = new Menu ($listOption->getOptionName(),"fa fa-user-o","#",true,$menu);
                  
                  foreach ($groups as $group) {
                      $str = $group->getName();
                      if (strlen($str)>$this->_maxStr) {
                          $str = substr($str, 0, $this->_maxStr-3)." ...";
                      }

                      $menuItemItem = new Menu ($str,"fa fa-circle-o","GroupView.php?GroupID=" . $group->getID(),true,$menuItem);
                      $menuItemItem->addLink("GroupEditor.php?GroupID=" . $group->getID());
                      $menuItemItem->addLink("GroupPropsFormEditor.php?GroupID=" . $group->getID());
                      if (SystemConfig::getValue('sMapProvider') == 'OpenStreetMap') {
                        $menuItemItem->addLink("MapUsingLeaflet.php?GroupID=" . $group->getID());
                      } else if (SystemConfig::getValue('sMapProvider') == 'GoogleMaps'){
                        $menuItemItem->addLink("MapUsingGoogle.php?GroupID=" . $group->getID());
                      } else if (SystemConfig::getValue('sMapProvider') == 'BingMaps') {
                        $menuItemItem->addLink("MapUsingBing.php?GroupID=" . $group->getID());
                      }
                  }
              }
          }
      }
      
      // now we're searching the unclassified groups
      $groups=GroupQuery::Create()
                  ->filterByType(0)
                  ->orderByName()
                  ->find();

      if ($groups->count()>0) {// only if the groups exist : !empty doesn't work !
          $menuItem = new Menu (gettext("Unassigned"),"fa fa-user-o","#",true,$menu);

          foreach ($groups as $group) {
              $menuItemItem = new Menu ( $group->getName(),"fa fa-angle-double-right","GroupView.php?GroupID=" . $group->getID(),true,$menuItem);
              $menuItemItem->addLink("GroupEditor.php?GroupID=" . $group->getID());
              $menuItemItem->addLink("GroupPropsFormEditor.php?GroupID=" . $group->getID());
          }
      }
      
      $menuItem = new Menu (gettext("Group Assignment Helper"),"fa fa-circle-o","SelectList.php?mode=groupassign",true,$menu);
            
      $this->addMenu($menu);
    }
    
    private function addSundaySchoolGroups()
    {
      //Get the Properties assigned to all the sunday Group
      $ormAssignedProperties = Record2propertyR2pQuery::Create()
                      ->addJoin(Record2propertyR2pTableMap::COL_R2P_PRO_ID,PropertyTableMap::COL_PRO_ID,Criteria::LEFT_JOIN)
                      ->addJoin(PropertyTableMap::COL_PRO_PRT_ID,PropertyTypeTableMap::COL_PRT_ID,Criteria::LEFT_JOIN)
                      ->addJoin(Record2propertyR2pTableMap::COL_R2P_RECORD_ID,GroupTableMap::COL_GRP_ID,Criteria::LEFT_JOIN)
                      ->addAsColumn('ProName',PropertyTableMap::COL_PRO_NAME)
                      ->addAsColumn("GroupId",GroupTableMap::COL_GRP_ID)
                      ->addAsColumn("GroupName",GroupTableMap::COL_GRP_NAME)
                      ->where(PropertyTableMap::COL_PRO_CLASS." = 'm' AND ".GroupTableMap::COL_GRP_TYPE." = '4' AND ". PropertyTypeTableMap::COL_PRT_NAME." = 'MENU'")
                      ->addAscendingOrderByColumn('ProName')
                      ->addAscendingOrderByColumn('groupName')
                      ->find();

      //Get the sunday groups not assigned by properties
      $ormWithoutAssignedProperties = GroupQuery::Create()
                      ->addJoin(GroupTableMap::COL_GRP_ID,Record2propertyR2pTableMap::COL_R2P_RECORD_ID,Criteria::LEFT_JOIN)
                      ->addJoin(Record2propertyR2pTableMap::COL_R2P_PRO_ID,PropertyTableMap::COL_PRO_ID,Criteria::LEFT_JOIN)
                      ->addJoin(PropertyTableMap::COL_PRO_PRT_ID,PropertyTypeTableMap::COL_PRT_ID,Criteria::LEFT_JOIN)
                      ->addAsColumn('PrtName',PropertyTypeTableMap::COL_PRT_NAME)
                      ->addAsColumn("GroupId",GroupTableMap::COL_GRP_ID)
                      ->addAsColumn("GroupName",GroupTableMap::COL_GRP_NAME)
                      ->where("((".Record2propertyR2pTableMap::COL_R2P_RECORD_ID." IS NULL) OR (".PropertyTypeTableMap::COL_PRT_NAME." != 'Menu')) AND ".GroupTableMap::COL_GRP_TYPE." = '4'")
                      ->addAscendingOrderByColumn('groupName')
                      ->find();
                      
      $menu = new Menu (gettext("Sunday School"),"fa fa-child","#",true);
      
      $menuItem = new Menu (gettext("Dashboard"),"fa fa-circle-o","sundayschool/SundaySchoolDashboard.php",true,$menu);
      
      
      $property = '';
      foreach ($ormAssignedProperties as $ormAssignedProperty) {
          if ($ormAssignedProperty->getProName() != $property) {
            $menuItem = new Menu ($ormAssignedProperty->getProName(),"fa fa-user-o","#",true,$menu);
            
            $property = $ormAssignedProperty->getProName();
          }

          $str = gettext($ormAssignedProperty->getGroupName());
          if (strlen($str)>$this->_maxStr) {
              $str = substr($str, 0, $this->_maxStr-3)." ...";
          }
          
          $menuItemItem = new Menu ($str,"fa fa-circle-o","sundayschool/SundaySchoolClassView.php?groupId=" . $ormAssignedProperty->getGroupId(),true,$menuItem);
          $menuItemItem->addLink("GroupEditor.php?GroupID=" . $ormAssignedProperty->getGroupId());
          $menuItemItem->addLink("GroupView.php?GroupID=" . $ormAssignedProperty->getGroupId());
          $menuItemItem->addLink("sundayschool/SundaySchoolBadge.php?groupId=" . $ormAssignedProperty->getGroupId());
      }
      
      // the non assigned group to a group property
      if ($ormWithoutAssignedProperties->count()>0) {// only if the groups exist : !empty doesn't work !
          $menuItem = new Menu (gettext("Unassigned"),"fa fa-user-o","#",true,$menu);
          
          foreach ($ormWithoutAssignedProperties as $ormWithoutAssignedProperty) {
              $str = gettext($ormWithoutAssignedProperty->getGroupName());
              if (strlen($str)>$this->_maxStr) {
                  $str = substr($str, 0, $this->_maxStr-3)." ...";
              }
              
              $menuItemItem = new Menu ($str,"fa fa-circle-o","sundayschool/SundaySchoolClassView.php?groupId=" . $ormWithoutAssignedProperty->getGroupId(),true,$menuItem);
              $menuItemItem->addLink("GroupEditor.php?GroupID=" . $ormWithoutAssignedProperty->getGroupId());
              $menuItemItem->addLink("GroupView.php?GroupID=" . $ormWithoutAssignedProperty->getGroupId());
          }
      }
      
      $this->addMenu($menu);
    }
    
    private function addGlobalMenuLinks()
    {
      $menuLinks = MenuLinkQuery::Create()->orderByOrder(Criteria::ASC)->findByPersonId(null);
      
      if ($menuLinks->count()) {
        $menu = new Menu (gettext("Global Custom Menus"),"fa fa-link","",true,null,"global_custom_menu");        
        $menu->addLink("v2/menulinklist");

        foreach ($menuLinks as $menuLink) {
            $menuItem = new Menu ($menuLink->getName(),"fa fa-circle-o",$menuLink->getUri(),true,$menu);
        }
      } else {
        $menu = new Menu (gettext("Global Custom Menus"),"fa fa-link","v2/menulinklist",true,null,"global_custom_menu");
      }
      
      
      $this->addMenu($menu);
    }
    
    private function addPersonMenuLinks($mainmenu)
    {
      $menuLinks = MenuLinkQuery::Create()->orderByOrder(Criteria::ASC)->findByPersonId(SessionUser::getUser()->getPersonId());
      
      $menuItem = new Menu (gettext("Custom Menus"),"fa fa-link","#",true,$mainmenu,"personal_custom_menu_".SessionUser::getUser()->getPersonId());
      $menuItem1 = new Menu (gettext("Dashboard"),"fa fa-circle-o","v2/menulinklist/".SessionUser::getUser()->getPersonId(),true,$menuItem);
      
      foreach ($menuLinks as $menuLink) {
          $menuItemItem1 = new Menu ($menuLink->getName(),"fa fa-angle-double-right",$menuLink->getUri(),true,$menuItem);
      }
    }
    
    private function createMenuBar ()
    {
      // home Area
      $menu = new Menu (gettext("Private Space"),"fa fa-home","",true);

        $menuItem = new Menu (gettext("Home"),"fa fa-user","PersonView.php?PersonID=".SessionUser::getUser()->getPersonId(),true,$menu);
        $menuItem = new Menu (gettext("Change Password"),"fa fa-key","UserPasswordChange.php",true,$menu);
        $menuItem = new Menu (gettext("Change Settings"),"fa fa-gear","SettingsIndividual.php",true,$menu);
        $menuItem = new Menu (gettext("Documents"),"fa fa fa-files-o","PersonView.php?PersonID=".SessionUser::getUser()->getPersonId()."&documents=true",true,$menu);
        $menuItem = new Menu (gettext("EDrive"),"fa fa-cloud","PersonView.php?PersonID=".SessionUser::getUser()->getPersonId()."&edrive=true",true,$menu);
        
        if (SystemConfig::getBooleanValue("bEnabledMenuLinks")) {
           $this->addPersonMenuLinks($menu);
        }

      $this->addMenu($menu);
      
      if (SessionUser::getUser()->isGdrpDpoEnabled() && SystemConfig::getValue('bGDPR')) {
        // the GDPR Menu
        $menu = new Menu (gettext("GDPR"),"fa fa-get-pocket pull-right&quot;","",true);
          $menuItem = new Menu (gettext("Dashboard"),"fa fa-rebel","v2/gdpr",true,$menu);
          $menuItem = new Menu (gettext("Data Structure"),"fa fa-user-secret","v2/gdpr/gdprdatastructure",true,$menu);
          $menuItem = new Menu (gettext("View Inactive Persons"),"fa fa-circle-o","PersonList.php?mode=GDRP",true,$menu);
          $menuItem = new Menu (gettext("View Inactive Families"),"fa fa-circle-o","FamilyList.php?mode=GDRP",true,$menu);
          
        $this->addMenu($menu);
      }
      
      // the Events Menu
      if (SystemConfig::getBooleanValue("bEnabledEvents")) {
        $menu = new Menu (gettext("Events"),"fa fa-ticket pull-right&quot;","",true);
          // add the badges
          $menu->addBadge('label bg-blue pull-right','AnniversaryNumber',0);
          $menu->addBadge('label bg-red pull-right','BirthdateNumber',0);
          $menu->addBadge('label bg-yellow pull-right','EventsNumber',0);

          $menuItem = new Menu (gettext("Calendar"),"fa fa-calendar fa-calendar pull-left&quot;","v2/calendar",true,$menu);
          if (SystemConfig::getValue('sMapProvider') == 'OpenStreetMap') {
            $menuItem = new Menu (gettext("View on Map"),"fa fa-map-o","MapUsingLeaflet.php",true,$menu);
          } else if (SystemConfig::getValue('sMapProvider') == 'GoogleMaps'){
            $menuItem = new Menu (gettext("View on Map"),"fa fa-map-o","MapUsingGoogle.php",true,$menu);
          } else if (SystemConfig::getValue('sMapProvider') == 'BingMaps') {
            $menuItem = new Menu (gettext("View on Map"),"fa fa-map-o","MapUsingBing.php",true,$menu);
          }

          $menuItem = new Menu (gettext("List Church Events"),"fa fa-circle-o","ListEvents.php",true,$menu);
          $menuItem = new Menu (gettext("List Event Types"),"fa fa-circle-o","EventNames.php",SessionUser::getUser()->isAdmin(),$menu);
          $menuItem = new Menu (gettext("Check-in and Check-out"),"fa fa-circle-o","Checkin.php",true,$menu);
      
        $this->addMenu($menu);
      }
      
      // the People menu
      $menu = new Menu (gettext("People")." & ".gettext("Families"),"fa fa-users","#",true);
      
        $menuItem = new Menu (gettext("Dashboard"),"fa fa-circle-o","PeopleDashboard.php",SessionUser::getUser()->isAddRecordsEnabled(),$menu);
        $menuItem->addLink("MapUsingLeaflet.php?GroupID=-1");
        $menuItem->addLink("MapUsingGoogle.php?GroupID=-1");
        $menuItem->addLink("MapUsingBing.php?GroupID=-1");
        $menuItem->addLink("GeoPage.php");
        $menuItem->addLink("UpdateAllLatLon.php");
        
        $menuItem = new Menu (gettext("View All Persons"),"fa fa-circle-o","SelectList.php?mode=person",true,$menu);
        if (SessionUser::getUser()->isShowMapEnabled()) {
          if (SystemConfig::getValue('sMapProvider') == 'OpenStreetMap') {
            $menuItem = new Menu (gettext("View on Map"),"fa fa-map-o","MapUsingLeaflet.php?GroupID=-1",true,$menu);
          } else if (SystemConfig::getValue('sMapProvider') == 'GoogleMaps'){
            $menuItem = new Menu (gettext("View on Map"),"fa fa-map-o","MapUsingGoogle.php?GroupID=-1",true,$menu);
          } else if (SystemConfig::getValue('sMapProvider') == 'BingMaps') {
            $menuItem = new Menu (gettext("View on Map"),"fa fa-map-o","MapUsingBing.php?GroupID=-1",true,$menu);
          }
        }
        
        $menuItem = new Menu (gettext("Directory reports"),"fa fa-circle-o","DirectoryReports.php",true,$menu);
        
        if (SessionUser::getUser()->isEditRecordsEnabled()) {
          $menuItem = new Menu (gettext("Persons"),"fa fa-angle-double-right","#",true,$menu);
            $menuItemItem = new Menu (gettext("Add New Person"),"fa fa-circle-o","PersonEditor.php",SessionUser::getUser()->isAddRecordsEnabled(),$menuItem);
            $menuItemItem = new Menu (gettext("View Active Persons"),"fa fa-circle-o","PersonList.php",true,$menuItem);
            $menuItemItem = new Menu (gettext("View Inactive Persons"),"fa fa-circle-o","PersonList.php?mode=inactive",true,$menuItem);
        
          $menuItem = new Menu (gettext("Families"),"fa fa-angle-double-right","#",true,$menu);
            $menuItemItem = new Menu (gettext("Add New Family"),"fa fa-circle-o","FamilyEditor.php",SessionUser::getUser()->isAddRecordsEnabled(),$menuItem);
            $menuItemItem = new Menu (gettext("View Active Families"),"fa fa-circle-o","FamilyList.php",true,$menuItem);
            $menuItemItem = new Menu (gettext("View Inactive Families"),"fa fa-circle-o","FamilyList.php?mode=inactive",true,$menuItem);
        }

      $this->addMenu($menu);
      
      // we add the groups
      $this->addGroups();
      
      // we add the sundayschool groups
      if (SystemConfig::getBooleanValue("bEnabledSundaySchool")) {
        $this->addSundaySchoolGroups();
      }
      
      
      // the Email
      if (SessionUser::getUser()->isMailChimpEnabled()) {
        $menu = new Menu (gettext("Email"),"fa fa-envelope","#",true);
          
        $mailchimp = new MailChimpService();

        $menuMain = new Menu (gettext("MailChimp"),"fa fa-circle-o","#",SessionUser::getUser()->isMailChimpEnabled(),$menu);

        $menuItem = new Menu (gettext("Dashboard"),"fa fa-circle-o","v2/mailchimp/dashboard",SessionUser::getUser()->isMailChimpEnabled(),$menuMain,"lists_class_main_menu");
        $menuItem->addLink("v2/mailchimp/duplicateemails");
        $menuItem->addLink("v2/mailchimp/notinmailchimpemails");
        $menuItem->addLink("v2/mailchimp/debug");
        
        $menuItemItem = new Menu (gettext("Email Lists"),"fa fa-circle-o","#",true,$menuMain,"lists_class_menu ".(($mailchimp->isLoaded())?"":"hidden"));

        if ($mailchimp->isLoaded()) {// to accelerate the Menu.php the first time
          $mcLists = $mailchimp->getLists();

          foreach ($mcLists as $list) {
            $menuItemItemItem = new Menu ($list['name']/*.' <small class="badge pull-right bg-blue current-deposit-item">'.$list['stats']['member_count'].'</small>'*/,"fa fa-circle-o","v2/mailchimp/managelist/".$list['id'],true,$menuItemItem,"listName".$list['id']);

            $campaigns = $mailchimp->getCampaignsFromListId($list['id']);
          
            foreach ($campaigns as $campaign) {
              //$menuItemItemItem = new Menu ($campaign['settings']['title'],"fa fa-circle-o","email/MailChimp/ManageList.php?list_id=".$list['id'],true,$menuItemItemItem);
              $menuItemItemItem->addLink("v2/mailchimp/campaign/".$campaign['id']);
            }
          }
        } else {// we add just a false item
          $menuItemItemItem = new Menu ("false item","fa fa-circle-o","#",true,$menuItemItem,"#");
        }

        $this->addMenu($menu);
      }
      
      // The deposit
      if (SystemConfig::getBooleanValue("bEnabledFinance") && SessionUser::getUser()->isFinanceEnabled()) {
        $menu = new Menu (gettext("Deposit"),"fa fa-bank","#",SessionUser::getUser()->isFinanceEnabled());
          // add the badges
          $deposit = DepositQuery::Create()->findOneById($_SESSION['iCurrentDeposit']);
          $deposits = DepositQuery::Create()->find();
        
          $numberDeposit = 0;
        
          if (!empty($deposits)) {
            $numberDeposit = $deposits->count();
          }

          //echo '<small class="badge pull-right bg-green count-deposit">'.$numberDeposit. "</small>".((!empty($deposit))?('<small class="badge pull-right bg-blue current-deposit" data-id="'.$_SESSION['iCurrentDeposit'].'">'.gettext("Current")." : ".$_SESSION['iCurrentDeposit'] . "</small>"):"")."\n";
          $menu->addBadge('badge pull-right bg-green count-deposit','',$numberDeposit);
          if (!empty($deposit)) {
            $menu->addBadge('badge pull-right bg-blue current-deposit','',gettext("Current")." : ".$_SESSION['iCurrentDeposit'],$_SESSION['iCurrentDeposit']);
          }

          $menuItem = new Menu (gettext("Envelope Manager"),"fa fa-circle-o","ManageEnvelopes.php",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("View All Deposits"),"fa fa-circle-o","FindDepositSlip.php",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("Electronic Payment Listing"),"fa fa-circle-o","ElectronicPaymentList.php",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("Deposit Reports"),"fa fa-circle-o","FinancialReports.php",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("Edit Deposit Slip").' : <small class="badge pull-right bg-blue current-deposit-item"> #'.$_SESSION['iCurrentDeposit'].'</small>',"fa fa-circle-o","DepositSlipEditor.php?DepositSlipID=".$_SESSION['iCurrentDeposit'],SessionUser::getUser()->isFinanceEnabled(),$menu,"deposit-current-deposit-item");
      
        $this->addMenu($menu);
      }
      
      // the menu Fundraisers
      if (SystemConfig::getBooleanValue("bEnabledFundraiser")) {
        $menu = new Menu (gettext("Fundraiser"),"fa fa-money","#",SessionUser::getUser()->isFinanceEnabled());

          $menuItem = new Menu (gettext("View All Fundraisers"),"fa fa-circle-o","FindFundRaiser.php",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("Create New Fundraiser"),"fa fa-circle-o","FundRaiserEditor.php?FundRaiserID=-1",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("Edit Fundraiser"),"fa fa-circle-o","FundRaiserEditor.php",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("View Buyers"),"fa fa-circle-o","PaddleNumList.php",SessionUser::getUser()->isFinanceEnabled(),$menu);
          $menuItem = new Menu (gettext("Add Donors to Buyer List"),"fa fa-circle-o","AddDonors.php",SessionUser::getUser()->isFinanceEnabled(),$menu);

        $this->addMenu($menu);
      }
      
      // the menu report
      $menu = new Menu (gettext("Data/Reports"),"fa fa-file-pdf-o","#",SessionUser::getUser()->isShowMenuQueryEnabled());

        $menuItem = new Menu (gettext("Reports Menu"),"fa fa-circle-o","ReportList.php",SessionUser::getUser()->isFinanceEnabled() && SystemConfig::getBooleanValue('bEnabledFinance') || SystemConfig::getBooleanValue('bEnabledSundaySchool'),$menu);
        $menuItem = new Menu (gettext("Query Menu"),"fa fa-circle-o","QueryList.php",SessionUser::getUser()->isShowMenuQueryEnabled(),$menu);

      if (SessionUser::getUser()->isShowMenuQueryEnabled()) {
        $this->addMenu($menu);
      }
      
      
      if (SystemConfig::getBooleanValue("bEnabledMenuLinks")) {
        $this->addGlobalMenuLinks();
      }
    }
    
    private function is_treeview_Opened($links)
    {
      $link = $_SERVER['REQUEST_URI'];
      
      foreach($links as $l) {
         if (!strcmp(SystemURLs::getRootPath() . "/" . $l,$link)) {
            return " active";
         }             
      }
      
      return "";
    }
    
    private function is_treeview_menu_open ($links)
    {
      $link = $_SERVER['REQUEST_URI'];
      
      foreach($links as $l) {
         if (!strcmp(SystemURLs::getRootPath() . "/" . $l,$link)) {
            return "class=\"treeview-menu menu-open\" style=\"display: block;\"";
         }             
      }
      
      return "class=\"treeview-menu menu-open\"";
    }
    
    private function is_li_class_active ($links,$is_menu=false,$class=null)
    {
      $link = $_SERVER['REQUEST_URI'];
      
      foreach($links as $l) {
         if (!strcmp(SystemURLs::getRootPath() . "/" . $l,$link)) {
            return "class=\"active ".(($is_menu)?"treeview":"").(($class !=null)?" ".$class:"")."\"";
         } else if ($is_menu) {
            return "class=\"treeview\"";
         }
      }
      
      return "";
    }
    
    private function addSubMenu($menus)
    {
      foreach ($menus as $menu) {
        $url = $menu->getUri();
        $real_link = true;
        
        if (strpos($menu->getUri(),"http") === false) {
          $real_link = false;
          $url = SystemURLs::getRootPath() . (($url != "#")?"/":"") . $url;
        }
        
        echo "<li ".$this->is_li_class_active($menu->getLinks(),(count($menu->subMenu()) > 0)?true:false)."><a href=\"".$url."\" ".(($real_link==true)?'target="_blank"':'')." ".(($menu->getClass() != null)?"class=\"".$menu->getClass()."\"":"")."><i class=\"".$menu->getIcon()."\"></i>".gettext($menu->getTitle());
        if (count($menu->subMenu()) > 0) {
          echo " <i class=\"fa fa-angle-left pull-right\"></i>\n";
        }
        
        echo "</a>\n";
        
        if (count($menu->subMenu()) > 0) {
          echo "<ul ".$this->is_treeview_menu_open($menu->getLinks()).">\n";
            $this->addSubMenu($menu->subMenu());
          echo "</ul>\n";
        }
        
        echo "</li>\n";
      }
    }
    
    public function renderMenu()
    {
      // render all the menus submenus etc ...
      echo "<ul class=\"sidebar-menu\" data-widget=\"tree\">\n";
      foreach ($this->_menus as $menu) {
        if (count($menu->subMenu()) == 0) {
          echo "<li ".$this->is_li_class_active($menu->getLinks(),false,$menu->getClass()).">\n";
          echo "<a href=\"".SystemURLs::getRootPath() . "/" . $menu->getUri()."\">\n";
          echo "<i class=\"".$menu->getIcon()."\"></i> <span>".gettext($menu->getTitle())."</span>\n";
          echo "</a>\n";
          echo "</li>\n";
        } else {// we are in the case of a treeview
          echo "<li class=\"treeview".$this->is_treeview_Opened($menu->getLinks()).(($menu->getClass() != null)?" ".$menu->getClass():"")."\">";
            echo "<a href=\"" . $menu->getUri() . "\">\n";// the menu keep his link #
            echo " <i class=\"".$menu->getIcon()."\"></i>\n";
            echo " <span>".gettext($menu->getTitle());
            if (count($menu->getBadges()) > 0) {
              foreach ($menu->getBadges() as $badge) {
                if ($badge['id'] != ''){
                  echo "<small class=\"".$badge['class']." badges-size\" id=\"".$badge['id']."\">".$badge['value']."</small>\n";
                } else if ($badge['data-id'] != ''){
                  echo "<small class=\"".$badge['class']." badges-size\" data-id=\"".$badge['data-id']."\">".$badge['value']."</small>\n"; 
                } else {
                  echo "<small class=\"".$badge['class']." badges-size\">".$badge['value']."</small>\n";
                }
              }
              echo "</span>\n";
            } else {
              echo " <i class=\"fa fa-angle-left pull-right\"></i>\n"."</span>\n";
            }
            echo "</a>\n";
            echo "<ul ".$this->is_treeview_menu_open($menu->getLinks()).">\n";
              $this->addSubMenu($menu->subMenu());
            echo "</ul>\n";
          echo "</li>\n";
        }          
      }
      echo "</ul>\n";
    }
}